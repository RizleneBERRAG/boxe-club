<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Plan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class EnrollmentController extends Controller
{
    /**
     * Étape 1 – Formulaire d’inscription
     */
    public function step1()
    {
        // Si tu as un modèle Plan, tu peux lui passer la liste ici
        $plans = Plan::all();

        return view('enroll.step1', compact('plans'));
    }

    /**
     * Traitement de l’étape 1
     */
    public function postStep1(Request $request)
    {
        // Adapte les règles à ton vrai formulaire step1
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email',
            'phone'      => 'required|string|max:30',
            // on choisit un plan existant
            'plan_id'    => 'required|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($data['plan_id']);

        // Création du dossier d’inscription
        $enrollment = Enrollment::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'],
            'plan_id'    => $plan->id,
            'status'     => 'pending',      // cohérent avec step3
            // 'dossier_ref' doit être généré dans ton modèle ou via un mutator
        ]);

        // On garde la réf du dossier en session pour l’étape 2
        session(['enroll_ref' => $enrollment->dossier_ref]);

        return redirect()->route('enroll.step2');
    }

    /**
     * Étape 2 – Page choix mode de paiement
     */
    public function step2(Request $request)
    {
        // On récupère la ref stockée à l’étape 1 OU reçue en query
        $ref = session('enroll_ref') ?? $request->query('ref');

        if (!$ref) {
            return redirect()
                ->route('enroll.step1')
                ->with('error', 'Votre session d’inscription a expiré, merci de recommencer.');
        }

        // Dossier + formule
        $enrollment = Enrollment::with('plan')
            ->where('dossier_ref', $ref)
            ->firstOrFail();

        $plan         = $enrollment->plan;
        $amount       = $plan->price_cents;      // en centimes (cohérent avec ta vue)
        $splitAllowed = $amount >= 20000;        // ex : 2x si + de 200 €

        return view('enroll.step2', compact(
            'enrollment',
            'plan',
            'amount',
            'splitAllowed'
        ));
    }

    /**
     * Traitement de l’étape 2 – création du paiement (Stripe ou pas)
     */
    public function postStep2(Request $request)
    {
        $data = $request->validate([
            'ref'            => 'required|string',
            'payment_method' => 'required|in:card,cash,wire',
            'split'          => 'nullable',
            'use_passsport'  => 'nullable',
        ]);

        // 1) On retrouve le dossier
        $enrollment = Enrollment::with('plan')
            ->where('dossier_ref', $data['ref'])
            ->firstOrFail();

        $plan  = $enrollment->plan;
        $gross = $plan->price_cents;                        // montant de base
        $aid   = !empty($data['use_passsport']) ? 7000 : 0; // -70 € en centimes
        $net   = max(0, $gross - $aid);                     // net en centimes
        $split = !empty($data['split']);

        // 2) On crée un Payment en base
        $payment = Payment::create([
            'enrollment_id' => $enrollment->id,
            'amount_cents'  => $net,
            'status'        => 'pending',                  // on passera à "paid" plus tard
            'method'        => $data['payment_method'],    // card | cash | wire
            'meta'          => [
                'gross_cents' => $gross,
                'aid_cents'   => $aid,
                'net_cents'   => $net,
                'pass_sport'  => !empty($data['use_passsport']),
                'split'       => $split,
            ],
        ]);

        // On enregistre la méthode sur le dossier
        $enrollment->update([
            'payment_method' => $data['payment_method'],
            'status'         => 'pending',
        ]);

        // 3) CAS ESPÈCES / VIREMENT → pas de Stripe
        if ($data['payment_method'] !== 'card') {
            return redirect()
                ->route('enroll.step3', ['ref' => $enrollment->dossier_ref])
                ->with('info', 'Paiement enregistré comme "En attente".');
        }

        // 4) CAS CARTE → Stripe Checkout
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'mode'                => 'payment',
            'payment_method_types'=> ['card'],
            'line_items'          => [[
                'quantity'   => 1,
                'price_data' => [
                    'currency'    => 'eur',
                    'unit_amount' => $net,
                    'product_data'=> [
                        'name' => 'Inscription Team Bafounta – ' .
                            $enrollment->first_name . ' ' . $enrollment->last_name .
                            ' (' . $plan->name . ')',
                    ],
                ],
            ]],
            'success_url' => route('enroll.step3', [
                'ref'        => $enrollment->dossier_ref,
                'session_id' => '{CHECKOUT_SESSION_ID}',
            ]),
            'cancel_url'  => route('enroll.step2') . '?cancel=1',
        ]);

        // On range l’ID de session Stripe sur le paiement
        $payment->update([
            'stripe_session_id' => $session->id,
        ]);

        // Redirection vers Stripe
        return redirect($session->url);
    }

    /**
     * Étape 3 – Attestation
     */
    public function step3(Request $request)
    {
        $ref = $request->query('ref');

        if (!$ref) {
            return redirect()->route('enroll.step1')
                ->with('error', 'Référence de dossier manquante.');
        }

        $enrollment = Enrollment::with(['plan', 'payments'])
            ->where('dossier_ref', $ref)
            ->firstOrFail();

        $isPaid = $enrollment->status === 'paid';

        // Si on revient de Stripe avec une session
        if ($request->has('session_id')) {
            $sessionId = $request->query('session_id');

            Stripe::setApiKey(config('services.stripe.secret'));
            $stripeSession = StripeSession::retrieve($sessionId);

            if ($stripeSession->payment_status === 'paid') {

                $payment = $enrollment->payments()
                    ->where('stripe_session_id', $stripeSession->id)
                    ->first();

                if ($payment && $payment->status !== 'paid') {
                    $payment->update(['status' => 'paid']);
                }

                if ($enrollment->status !== 'paid') {
                    $enrollment->update([
                        'status'         => 'paid',
                        'payment_method' => 'card',
                    ]);
                }

                $isPaid = true;
            }
        }

        return view('enroll.step3', compact('enrollment', 'isPaid'));
    }
}
