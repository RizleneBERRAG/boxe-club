<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnrollmentRequest;
use App\Models\{Enrollment, Plan, Payment};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EnrollmentController extends Controller
{
    // ÉTAPE 1 — FORMULAIRE
    public function step1()
    {
        $plans = Plan::where('is_active', 1)->orderBy('price_cents')->get();
        return view('enroll.step1', compact('plans'));
    }

    public function postStep1(StoreEnrollmentRequest $request)
    {
        $data = $request->validated();
        $data['status'] = 'draft';

        // Référence unique
        $data['dossier_ref'] = 'TBF-'.date('Y').'-'.strtoupper(Str::random(6));

        $enrollment = Enrollment::create($data);

        return redirect()->route('enroll.step2', ['ref' => $enrollment->dossier_ref]);
    }

    // ÉTAPE 2 — PAIEMENT
    public function step2(Request $request)
    {
        $ref = $request->query('ref');

        $enrollment = Enrollment::where('dossier_ref', $ref)
            ->with('plan')
            ->firstOrFail();

        $plan         = $enrollment->plan;
        $amount       = $plan->price_cents;
        $splitAllowed = (bool) $plan->allow_split;

        return view('enroll.step2', compact('enrollment','plan','amount','splitAllowed'));
    }

    public function postStep2(Request $request)
    {
        $request->validate([
            'ref'            => ['required','string'],
            'payment_method' => ['required','in:card,cash,wire'],
            'split'          => ['nullable','boolean'],
            'use_passsport'  => ['nullable','boolean'], // aide
        ]);

        $ref = $request->input('ref');

        $enrollment = Enrollment::where('dossier_ref', $ref)
            ->with('plan')
            ->firstOrFail();

        $plan    = $enrollment->plan;
        $method  = $request->payment_method;
        $usePass = (bool) $request->boolean('use_passsport');

        // calcul net (aide Pass'Sport déduite)
        $aidCents = $usePass ? 5000 : 0; // 50€
        $netCents = max(0, $plan->price_cents - $aidCents);

        DB::transaction(function () use ($enrollment, $plan, $method, $usePass, $aidCents, $netCents, $request) {
            $status = 'pending';
            if ($method === 'card' && !$usePass) {
                $status = 'paid';
            }

            Payment::create([
                'enrollment_id' => $enrollment->id,
                'amount_cents'  => $netCents,
                'method'        => $method,   // card|cash|wire
                'status'        => $status,   // pending|paid
                'meta'          => [
                    'split'       => (bool) $request->boolean('split'),
                    'pass_sport'  => $usePass,
                    'aid_cents'   => $aidCents,
                    'gross_cents' => $plan->price_cents,
                    'net_cents'   => $netCents,
                ],
            ]);

            $enrollment->update([
                'payment_method' => $method,
                'status'         => $status,
            ]);
        });

        return redirect()->route('enroll.step3', ['ref' => $enrollment->dossier_ref]);
    }

    // ÉTAPE 3 — ATTESTATION
    public function step3(Request $request)
    {
        $ref = $request->query('ref');

        $enrollment = Enrollment::where('dossier_ref', $ref)
            ->with('plan','payments')
            ->firstOrFail();

        $isPaid = $enrollment->status === 'paid';

        return view('enroll.step3', compact('enrollment','isPaid'));
    }
}
