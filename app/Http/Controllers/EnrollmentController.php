<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Plan;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Str;

class EnrollmentController extends Controller
{
    /**
     * Étape 1 – Formulaire d’inscription
     */
    public function step1()
    {
        $plans = Plan::all();
        return view('enroll.step1', compact('plans'));
    }

    /**
     * Traitement de l’étape 1
     */
    public function postStep1(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email',
            'phone'      => 'required|string|max:30',
            'plan_id'    => 'required|exists:plans,id',
            'birthdate' => 'required|date',
        ]);

        $plan = Plan::findOrFail($data['plan_id']);

        $enrollment = Enrollment::create([
            'first_name'  => $data['first_name'],
            'last_name'   => $data['last_name'],
            'email'       => $data['email'],
            'phone'       => $data['phone'],
            'birthdate'   => $data['birthdate'],   // ✅ AJOUT
            'plan_id'     => $plan->id,
            'status'      => 'pending',
            'dossier_ref' => 'ENR-' . strtoupper(Str::random(8)),
        ]);


        session(['enroll_ref' => $enrollment->dossier_ref]);

        return redirect()->route('enroll.step2');
    }

    /**
     * Étape 2 – Page choix mode de paiement
     */
    public function step2(Request $request)
    {
        $ref = session('enroll_ref') ?? $request->query('ref');

        if (!$ref) {
            return redirect()
                ->route('enroll.step1')
                ->with('error', 'Votre session d’inscription a expiré, merci de recommencer.');
        }

        $enrollment = Enrollment::with('plan')
            ->where('dossier_ref', $ref)
            ->firstOrFail();

        $plan         = $enrollment->plan;
        $amount       = $plan->price_cents;
        $splitAllowed = $amount >= 20000;

        return view('enroll.step2', compact('enrollment', 'plan', 'amount', 'splitAllowed'));
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
            'force_free'     => 'nullable', // ✅ test local
        ]);

        $enrollment = Enrollment::with('plan')
            ->where('dossier_ref', $data['ref'])
            ->firstOrFail();

        $plan  = $enrollment->plan;
        $gross = (int) $plan->price_cents;

        $aid = !empty($data['use_passsport']) ? 7000 : 0;
        $net = max(0, $gross - $aid);

        // ✅ Forcer 0€ uniquement en local (test)
        // ... après calcul $gross, $aid, $net, $split

// ✅ Forcer 0€ uniquement en local (test)
        $forcedFree = app()->environment('local') && $request->boolean('force_free');
        if ($forcedFree) {
            $net = 0;
        }
        $split = !empty($data['split']);

// 2) On crée un Payment en base
        $payment = Payment::create([
            'enrollment_id' => $enrollment->id,
            'amount_cents'  => $net,
            'status'        => 'pending',
            'method'        => $data['payment_method'], // card | cash | wire
            'meta'          => [
                'gross_cents'   => $gross,
                'aid_cents'     => $aid,
                'net_cents'     => $net,
                'pass_sport'    => !empty($data['use_passsport']),
                'split'         => $split,
                'forced_free'   => $forcedFree,
            ],
        ]);

        $enrollment->update([
            'payment_method' => $data['payment_method'],
            'status'         => 'pending',
        ]);

// ✅ CAS MONTANT = 0 € → validation directe (sans Stripe)
        if ($net === 0) {
            $payment->update([
                'status' => 'paid',
                // 🚫 surtout PAS method = 'free' si ta DB ne l'accepte pas
            ]);

            $enrollment->update([
                'status' => 'paid',
                // 🚫 pareil : ne mets pas payment_method = 'free' si ta DB ne l'accepte pas
            ]);

            return redirect()
                ->route('enroll.step3', ['ref' => $enrollment->dossier_ref])
                ->with('success', 'Inscription validée (montant 0 €).');
        }

// ... ensuite seulement : Stripe Checkout si net > 0


        // ✅ Espèces / virement : pas de Stripe
        if ($data['payment_method'] !== 'card') {
            return redirect()
                ->route('enroll.step3', ['ref' => $enrollment->dossier_ref])
                ->with('info', 'Paiement enregistré comme "En attente".');
        }

        // 3) Carte : Stripe Checkout
        Stripe::setApiKey(config('services.stripe.secret'));

        $session = StripeSession::create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $net,
                    'product_data' => [
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
            'cancel_url'  => route('enroll.step2') . '?ref=' . $enrollment->dossier_ref . '&cancel=1',
        ]);

        $payment->update([
            'stripe_session_id' => $session->id,
        ]);

        return redirect($session->url);
    }

    /**
     * Étape 3 – Attestation (ne valide plus Stripe ici)
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

        return view('enroll.step3', compact('enrollment', 'isPaid'));
    }
}
