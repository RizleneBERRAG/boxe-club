@extends('layouts.minimal-admin')

@section('content')
    <div style="max-width:900px;margin:30px auto;padding:0 16px;color:#fff;">

        <h1>Dossier {{ $enrollment->dossier_ref }}</h1>

        @if(session('success'))
            <div style="background:#1f7a3a;padding:10px 12px;border-radius:10px;margin:12px 0;">
                {{ session('success') }}
            </div>
        @endif

        <div style="background:#0f0f10;border:1px solid #222;border-radius:14px;padding:14px;margin:12px 0;">
            <div><strong>Nom :</strong> {{ $enrollment->first_name }} {{ $enrollment->last_name }}</div>
            <div><strong>Email :</strong> {{ $enrollment->email }}</div>
            <div><strong>Téléphone :</strong> {{ $enrollment->phone }}</div>
            <div><strong>Formule :</strong> {{ $enrollment->plan?->name }}</div>
            <div><strong>Statut :</strong> {{ $enrollment->status }}</div>
            <div><strong>Méthode :</strong> {{ $enrollment->payment_method }}</div>
        </div>

        <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
            @if($enrollment->status !== 'paid')
                <form method="POST" action="{{ route('admin.enrollments.markPaid', $enrollment) }}"
                      onsubmit="return confirm('Confirmer le paiement de ce dossier ?')">
                    @csrf
                    @method('PATCH')
                    <button style="padding:10px 14px;border-radius:10px;border:0;background:#1f7a3a;color:#fff;font-weight:800;">
                        ✔ Marquer PAYÉ
                    </button>
                </form>
            @else
                <span style="padding:10px 14px;border-radius:10px;background:#1f7a3a;color:#fff;font-weight:800;">
                Payé
            </span>
            @endif

            <form method="POST" action="{{ route('admin.enrollments.markPending', $enrollment) }}"
                  onsubmit="return confirm('Remettre ce dossier en attente ?')">
                @csrf
                @method('PATCH')
                <button style="padding:10px 14px;border-radius:10px;border:0;background:#444;color:#fff;font-weight:800;">
                    ⏳ Remettre EN ATTENTE
                </button>
            </form>

            <a href="{{ route('admin.enrollments.index') }}"
               style="padding:10px 14px;border-radius:10px;border:1px solid #333;color:#fff;text-decoration:none;">
                Retour liste
            </a>
        </div>

    </div>
@endsection
