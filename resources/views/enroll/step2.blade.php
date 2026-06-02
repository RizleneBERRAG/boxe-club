@extends('layouts.minimal')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/enroll.css') }}">
@endsection

@section('content')
    <section class="section enroll">
        {{-- Progression --}}
        <div class="wizard" aria-label="Progression">
            <div class="step-dot">1</div><div class="step-line"></div><div class="step-label">Infos</div>
            <div class="step-dot active">2</div><div class="step-line"></div><div class="step-label">Paiement</div>
            <div class="step-dot">3</div><div class="step-label">Attestation</div>
        </div>

        <h1 class="page-title">Inscription — Étape 2</h1>

        {{-- Récap --}}
        <div class="panel" data-reveal>
            <div class="kicker">Récap</div>
            <p class="muted">
                Dossier <strong>{{ $enrollment->dossier_ref }}</strong>
            </p>
            <p>
                <strong>Formule :</strong> {{ $plan->name }} —
                <strong>
                <span id="amountBase"
                      data-cents="{{ $amount }}">
                    {{ number_format($amount / 100, 2, ',', ' ') }} €
                </span>
                </strong>
            </p>
        </div>

        {{-- FORMULAIRE --}}
        <form method="POST" action="{{ route('enroll.postStep2') }}" class="panel" data-reveal>
            @csrf
            <input type="hidden" name="ref" value="{{ $enrollment->dossier_ref }}">

            {{-- MODE DE PAIEMENT --}}
            <div class="panel">
                <h3 class="kicker">Mode de paiement</h3>

                <div class="grid-2 pay-grid">
                    <label class="pay-tile is-active">
                        <input type="radio" name="payment_method" value="card" checked>
                        <div class="pay-title">Carte bancaire</div>
                        <div class="pay-text">Paiement instantané sécurisé. Option 2× disponible.</div>
                    </label>

                    <label class="pay-tile">
                        <input type="radio" name="payment_method" value="cash">
                        <div class="pay-title">Espèces</div>
                        <div class="pay-text">Règlement au club. Dossier en attente.</div>
                    </label>

                    <label class="pay-tile">
                        <input type="radio" name="payment_method" value="wire">
                        <div class="pay-title">Virement</div>
                        <div class="pay-text">Justificatif demandé. Dossier en attente.</div>
                    </label>
                </div>


                {{-- Paiement en 2x --}}
                @if($splitAllowed)
                    <div id="split-row" class="mt-2">
                        <label class="checkbox">
                            <input type="checkbox" name="split" value="1">
                            <span>
                        Payer en 2× (<span id="splitEach">—</span> / échéance : 01 Novembre)
                    </span>
                        </label>
                    </div>
                @endif
            </div>

            {{-- AIDES --}}
            <div class="panel">
                <h3 class="kicker">Aides & réductions</h3>

                <label class="checkbox">
                    <input type="checkbox" id="usePassSport" name="use_passsport" value="1">
                    <span>
                    Je bénéficie du <strong>Pass’Sport</strong> (–70,00 €)
                    — justificatif demandé au club.
                </span>
                </label>

                @if(app()->environment('local'))
                    <label class="checkbox mt-2">
                        <input type="checkbox" name="force_free" value="1">
                        <span>🔧 Forcer le montant à 0 € (test local)</span>
                    </label>
                @endif

            </div>

            {{-- TOTAL --}}
            <div class="panel amount-panel">
                <div>
                    Montant à régler :
                    <strong id="amountToP<div class="actions">
                    <button class="btn btn-primary" type="submit">
                        Continuer
                    </button>
                    <a class="btn btn-ghost" href="{{ route('enroll.step1') }}">
                        Retour
                    </a>
                </div>ay">—</strong>
                </div>
                <p class="muted" id="amountNote"></p>
            </div>

            {{-- ACTIONS --}}


            <p class="help">
                Carte bancaire : paiement via Stripe.<br>
                Espèces / Virement : dossier enregistré en attente.
            </p>
        </form>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/enroll.js') }}" defer></script>
@endsection
