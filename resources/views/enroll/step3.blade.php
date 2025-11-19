@extends('layouts.minimal')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/attestation.css') }}">
@endsection

@section('content')
    <section class="attest-wrap">

        {{-- Barre de progression --}}
        <div class="wiz">
            <div class="wiz-step done">1</div>
            <div class="wiz-line"></div>
            <div class="wiz-step done">2</div>
            <div class="wiz-line"></div>
            <div class="wiz-step active">3</div>
            <div class="wiz-label">Attestation</div>
        </div>

        {{-- Carte imprimable A4 --}}
        <article class="attest-card">
            <header class="attest-head">
                <div class="brand">
                    <div class="brand-mark">TB</div>
                    <div class="brand-text">
                        <strong>Team Bafounta</strong>
                        <small>Vénissieux • Boxe anglaise</small>
                    </div>
                </div>

                <div class="head-meta">
                    <div class="ref">Réf. dossier : <strong>{{ $enrollment->dossier_ref }}</strong></div>
                    <div class="date">{{ now()->format('d/m/Y H:i') }}</div>
                </div>
            </header>

            <div class="status-row {{ $isPaid ? 'paid' : 'pending' }}">
                @if($isPaid)
                    <span class="icon">✔</span>
                    <div>Paiement <strong>confirmé</strong>. Ton attestation est prête ci-dessous.</div>
                @else
                    <span class="icon">⏳</span>
                    <div>Paiement <strong>en attente</strong>. Les téléchargements resteront verrouillés.</div>
                @endif
            </div>

            <section class="attest-body">
                <h1>Bienvenue dans l’équipe 💥</h1>

                <div class="grid-2">
                    <div class="box">
                        <div class="k">Adhérent</div>
                        <div class="v">{{ $enrollment->first_name }} {{ $enrollment->last_name }}</div>
                    </div>
                    <div class="box">
                        <div class="k">Statut</div>
                        <div class="v">{{ $isPaid ? 'Payé' : 'En attente' }}</div>
                    </div>
                    <div class="box">
                        <div class="k">Formule</div>
                        <div class="v">{{ $enrollment->plan->name }}</div>
                    </div>
                    <div class="box">
                        <div class="k">Montant</div>
                        <div class="v">{{ number_format($enrollment->plan->price_cents/100, 2, ',', ' ') }} €</div>
                    </div>
                </div>

                @php
                    $payment = $enrollment->payments->last();
                    $meta = $payment?->meta ?? []; // déjà casté en array
                    $gross = $meta['gross_cents'] ?? $enrollment->plan->price_cents;
                    $aid   = $meta['aid_cents']   ?? 0;
                    $net   = $meta['net_cents']   ?? ($payment?->amount_cents ?? $gross - $aid);
                @endphp


                <ul class="receipt">
                    <li><span>Formule </span><strong>- {{ $enrollment->plan->name }}</strong></li>
                    <li><span>Montant </span><strong>- {{ number_format($gross/100, 2, ',', ' ') }} €</strong></li>
                    @if(($meta['pass_sport'] ?? false) || $aid > 0)
                        <li><span>Aide Pass’Sport</span><strong>- {{ number_format($aid/100, 2, ',', ' ') }} €</strong></li>
                    @endif
                    <li class="total"><span>Total réglé </span><strong>- {{ number_format($net/100, 2, ',', ' ') }} €</strong></li>
                </ul>

                <p class="muted">
                    @if($enrollment->status === 'paid')
                        Paiement confirmé.
                    @else
                        Paiement en attente de validation ({{ $enrollment->payment_method }}{{ ($meta['pass_sport'] ?? false) ? ' + Pass’Sport' : '' }}).
                    @endif
                </p>

                <div class="downloads">
                    <a class="btn btn-primary" href="#" onclick="window.print()" aria-label="Imprimer l’attestation">
                        Imprimer / Enregistrer en PDF
                    </a>

                    <div class="dl-list">
                        <a class="dl-link {{ $isPaid ? '' : 'is-locked' }}"
                           href="#"
                           tabindex="{{ $isPaid ? '0':'-1' }}"
                           @if(!$isPaid) aria-disabled="true" @endif>
                            Certificat médical
                        </a>
                        <a class="dl-link {{ $isPaid ? '' : 'is-locked' }}"
                           href="#"
                           tabindex="{{ $isPaid ? '0':'-1' }}"
                           @if(!$isPaid) aria-disabled="true" @endif>
                            Certificat ophtalmologique
                        </a>
                    </div>

                    @unless($isPaid)
                        <p class="muted tiny">* Les documents se débloqueront automatiquement dès validation du paiement.</p>
                    @endunless
                </div>
            </section>

            <footer class="attest-foot">
                <div>
                    <div class="club">Espace École Sport Boxe</div>
                    <div class="mail">espaceecolesportboxe@gmail.com</div>
                </div>
                <div class="legal">
                    <a href="{{ asset('assets/docs/mentions-legales-rgpd.pdf') }}" download rel="noopener">
                        Mentions légales &amp; RGPD
                    </a>
                </div>
            </footer>

            @if($isPaid)
                <div class="stamp">PAYÉ</div>
            @endif
        </article>

        <div class="after-actions no-print">
            <a class="btn btn-ghost" href="{{ route('home') }}">Retour à l’accueil</a>
        </div>
    </section>
@endsection
