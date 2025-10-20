@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/enroll.css') }}">
@endsection

@section('content')
    <section class="section enroll">
        <div class="wizard" aria-label="Progression">
            <div class="step-dot">1</div><div class="step-line"></div><div class="step-label">Infos</div>
            <div class="step-dot active">2</div><div class="step-line"></div><div class="step-label">Paiement</div>
            <div class="step-dot">3</div><div class="step-label">Attestation</div>
        </div>

        <h1 class="page-title">Inscription — Étape 2</h1>

        <div class="panel" data-reveal>
            <div class="kicker">Récap</div>
            <p class="muted">Dossier <strong>{{ $enrollment->dossier_ref }}</strong></p>
            <p><strong>Formule :</strong> {{ $plan->name }} — <strong>{{ number_format($amount/100, 2, ',', ' ') }} €</strong></p>
        </div>

        <form method="post" action="{{ route('enroll.postStep2') }}" class="panel" data-reveal>
            @csrf
            <input type="hidden" name="ref" value="{{ $enrollment->dossier_ref }}">

            <div class="kicker">Mode de paiement</div>

            {{-- RÉCAP --}}
            <div class="panel">
                <div class="muted">Dossier <strong>{{ $enrollment->dossier_ref }}</strong></div>
                <div>Formule : <strong>{{ $plan->name }}</strong> —
                    <span id="amountBase" data-cents="{{ $amount }}">{{ number_format($amount/100, 2, ',', ' ') }} €</span>
                </div>
            </div>

            {{-- MOYEN DE PAIEMENT --}}
            <div class="panel">
                <h3 class="kicker">Mode de paiement</h3>

                <div class="grid-2 pay-grid">
                    <label class="pay-tile {{ old('payment_method','card')==='card'?'is-active':'' }}">
                        <input type="radio" name="payment_method" value="card" {{ old('payment_method','card')==='card'?'checked':'' }}>
                        <div class="pay-title">Carte bancaire</div>
                        <div class="pay-text">Paiement instantané sécurisé. Option 2× disponible.</div>
                    </label>

                    <label class="pay-tile {{ old('payment_method')==='cash'?'is-active':'' }}">
                        <input type="radio" name="payment_method" value="cash" {{ old('payment_method')==='cash'?'checked':'' }}>
                        <div class="pay-title">Espèces</div>
                        <div class="pay-text">Régler directement au club ; dossier en attente de validation.</div>
                    </label>

                    <label class="pay-tile {{ old('payment_method')==='wire'?'is-active':'' }}">
                        <input type="radio" name="payment_method" value="wire" {{ old('payment_method')==='wire'?'checked':'' }}>
                        <div class="pay-title">Virement</div>
                        <div class="pay-text">Soumettre le justificatif au club ; dossier en attente de validation.</div>
                    </label>
                </div>

                @if($splitAllowed)
                    <label class="checkbox mt-2">
                        <input type="checkbox" name="split" value="1" {{ old('split')?'checked':'' }}>
                        <span>Payer en 2× (<span id="splitEach"></span> / échéance : 01 Novembre)</span>
                    </label>
                @endif
            </div>

            {{-- AIDES & RÉDUCTIONS --}}
            <div class="panel">
                <h3 class="kicker">Aides & réductions</h3>

                <label class="checkbox">
                    <input type="checkbox" id="usePassSport" name="use_passsport" value="1" {{ old('use_passsport')?'checked':'' }}>
                    <span>Je bénéficie du <strong>Pass’Sport</strong> (–50,00 €) — justificatif demandé au club.</span>
                </label>
            </div>

            {{-- RÉCAP MONTANT À RÉGLER --}}
            <div class="panel amount-panel">
                <div>Montant à régler : <strong id="amountToPay"></strong></div>
                <p class="muted" id="amountNote"></p>
            </div>

            <div class="actions">
                <button class="btn btn-primary" type="submit">Continuer</button>
                <a class="btn btn-ghost" href="{{ route('enroll.step1') }}">Retour</a>
            </div>

            <input type="hidden" name="ref" value="{{ $enrollment->dossier_ref }}">


        <p class="help">CB = succès simulé (statut <strong>Payé</strong>). Les autres modes restent en <strong>En attente</strong>.</p>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/enroll.js') }}" defer></script>
@endsection
