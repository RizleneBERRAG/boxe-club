<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentAdminController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status'); // paid | pending | null
        $q = $request->query('q'); // recherche

        $enrollments = Enrollment::with(['plan', 'payments'])
            ->when($status, fn($query) => $query->where('status', $status))
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('dossier_ref', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('first_name', 'like', "%{$q}%")
                        ->orWhere('last_name', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.enrollments.index', compact('enrollments', 'status', 'q'));
    }

    public function show(Enrollment $enrollment)
    {
        $enrollment->load(['plan', 'payments']);
        $lastPayment = $enrollment->payments->last();

        return view('admin.enrollments.show', compact('enrollment', 'lastPayment'));
    }

    public function markPaid(Request $request, Enrollment $enrollment)
    {
        DB::transaction(function () use ($enrollment) {

            $enrollment->loadMissing(['plan', 'payments']);

            // 1) Update dossier
            if ($enrollment->status !== 'paid') {
                $enrollment->update([
                    'status' => 'paid',
                    'payment_method' => $enrollment->payment_method ?: 'manual',
                ]);
            }

            // 2) Update / create payment
            $payment = $enrollment->payments()->latest()->first();

            if ($payment) {
                if ($payment->status !== 'paid') {
                    $payment->update([
                        'status' => 'paid',
                    ]);
                }
            } else {
                Payment::create([
                    'enrollment_id' => $enrollment->id,
                    'amount_cents'  => $enrollment->plan?->price_cents ?? 0,
                    'status'        => 'paid',
                    'method'        => $enrollment->payment_method ?: 'manual',
                    'meta'          => ['manual' => true],
                ]);
            }
        });

        return back()->with('success', 'Dossier marqué comme PAYÉ.');
    }

    public function markPending(Request $request, Enrollment $enrollment)
    {
        DB::transaction(function () use ($enrollment) {

            $enrollment->update(['status' => 'pending']);

            $payment = $enrollment->payments()->latest()->first();
            if ($payment) {
                $payment->update(['status' => 'pending']);
            }
        });

        return back()->with('success', 'Dossier remis en EN ATTENTE.');
    }
}
