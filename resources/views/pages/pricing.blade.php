@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pricing.css') }}">
@endsection

@section('content')

    @php
        $plans = \App\Models\Plan::where('is_active',1)->orderBy('price_cents')->get();
        $count = $plans->count();
    @endphp

    <section class="section pricing-page">
        <br>
        {{-- ========== HERO ========== --}}

        <header class="pricing-hero hero-with-video">
            <video class="hero-video" autoplay muted loop playsinline>
                <source src="/assets/video/video.mp4" type="video/mp4">
            </video>

            <div class="hero-overlay"></div>

            <p class="pricing-hero__eyebrow">Team Bafounta — Saison 2025/2026</p>
            <h1 class="pricing-hero__title">Tarifs & adhésions</h1>

            <p class="pricing-hero__subtitle">
                Des formules pensées pour progresser à ton rythme, en sécurité et en confiance.
            </p>

            <div class="pricing-hero__chips">
                <span class="pricing-chip">Encadrement diplômé</span>
                <span class="pricing-chip">Ambiance familiale</span>
                <span class="pricing-chip">Objectifs loisirs & compétition</span>
            </div>
        </header>

        {{-- ========== BANDEAU COURS D’ESSAI ========== --}}
        <section class="try-banner card">
            <div class="try-banner__left">
                <span class="try-banner__pill">Cours d’essai</span>
                <p class="try-banner__intro">
                    Viens tester la salle et les coachs sur une séance complète,
                    sans t’engager tout de suite.
                </p>
            </div>

            <div class="try-banner__center">
                <div class="try-banner__col">
                    <span class="try-banner__label">Éducative</span>
                    <span class="try-banner__price">30 €</span>
                </div>
                <div class="try-banner__col">
                    <span class="try-banner__label">Amateur</span>
                    <span class="try-banner__price">50 €</span>
                </div>
                <p class="try-banner__note">
                    Montant intégralement déduit de ta formule si tu t’inscris.
                </p>
            </div>

            <div class="try-banner__right">
                <a href="{{ route('contact') }}" class="btn btn-primary try-banner__btn">
                    Réserver une séance d’essai
                </a>
            </div>
        </section>


        {{-- ========== PLANS PRINCIPAUX ========== --}}
        @if($plans->isNotEmpty())
            <section class="plans-section">
                <h2 class="plans-title">Formules d’adhésion</h2>
                <p class="plans-subtitle">
                    Chaque formule inclut l’accès aux cours du planning correspondant, l’encadrement
                    par l’équipe et l’intégration à la vie du club.
                </p>

                <div class="pricing-grid">
                    @foreach($plans as $i => $p)
                        @php
                            // On force "Le plus choisi" sur la formule Boxe amateur
                            $isRec = trim(mb_strtolower($p->name)) === 'boxe amateur';
                            $price = number_format($p->price_cents/100, 2, ',', ' ');
                            $split = $p->allow_split ? number_format(($p->price_cents/2)/100, 2, ',', ' ') : null;
                        @endphp

                        <article class="price-card card {{ $isRec ? 'is-featured' : '' }}" data-reveal>
                            @if($isRec)
                                <div class="badge">Le plus choisi</div>
                            @endif

                            <h3 class="price-card__title">{{ $p->name }}</h3>

                            <div class="price-card__row">
                                <span class="price-card__currency">€</span>
                                <span class="price-card__amount">
                                    {{ str_replace([',',' '], ['.',' '], $price) }}
                                </span>
                                <span class="price-card__period">/ saison</span>
                            </div>

                            @if($split)
                                <p class="price-card__split">
                                    ou en 2× <strong>{{ $split }} €</strong>
                                </p>
                            @endif

                            @if($p->description)
                                <p class="price-card__desc">{{ $p->description }}</p>
                            @endif

                            <ul class="price-card__list">
                                <li>Accès aux cours de ta catégorie</li>
                                <li>Encadrement et corrections pendant les séances</li>
                                <li>Licence & assurance adaptées à ta pratique</li>
                            </ul>

                            <a class="btn btn-primary price-card__btn" href="{{ route('enroll.step1') }}">
                                Choisir cette formule
                            </a>
                        </article>
                    @endforeach

                    {{-- Tuile décorative avec logo pour combler le "trou" --}}
                        {{-- Tuile décorative avec logo pour combler le "trou" --}}
                        {{-- Logo flottant (sans cadre) pour combler le "trou" --}}
                        <div class="pricing-logo-free" aria-hidden="true" data-reveal>
                            <img src="{{ asset('assets/img/logo.png') }}" alt="Team Bafounta">
                        </div>



                </div>

                <br>
                <br>

                {{-- Bandeau "tout compris" --}}
                <div class="includes-strip card">
                    <p class="includes-strip__title">Avec toutes les formules :</p>
                    <div class="includes-strip__items">
                        <div class="includes-strip__item">
                            <span class="includes-strip__icon">🥊</span>
                            <span>Travail technique, sac, paos & mise de gants encadrée.</span>
                        </div>
                        <div class="includes-strip__item">
                            <span class="includes-strip__icon">🤝</span>
                            <span>Esprit club, événements, galas et déplacements.</span>
                        </div>
                        <div class="includes-strip__item">
                            <span class="includes-strip__icon">🧠</span>
                            <span>Respect, confiance, progression à ton rythme.</span>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <div class="card muted">Les formules seront publiées prochainement.</div>
        @endif

        {{-- ========== BLOCS D’INFOS ========== --}}
        <section class="extra-section">

            <div class="info-row">
                <article class="info-block card">
                    <h2 class="info-title">Équipement obligatoire</h2>
                    <p class="info-text">
                        Pour boxer en sécurité, un pack complet est nécessaire. Le club t’accompagne
                        pour choisir les bonnes tailles et le matériel adapté à ton niveau.
                    </p>
                    <ul class="info-list">
                        <li>
                            <strong>Pack complets nouveaux adhérents</strong> :
                            150 € (boxe éducative) • 200 € (boxe amateur)
                        </li>
                        <li>
                            <strong>Tenue seule</strong> :
                            60 € (éducative) • 90 € (amateur)
                        </li>
                    </ul>
                </article>

                <article class="info-block card">
                    <h2 class="info-title">Assurance & déplacements</h2>
                    <p class="info-text">
                        Pour les compétiteurs, le club organise les déplacements officiels et
                        sécurise les trajets avec une assurance adaptée.
                    </p>
                    <ul class="info-list">
                        <li>Région lyonnaise : 12 €</li>
                        <li>Hors région ≤ 150 km : 30 €</li>
                        <li>> 150 km : 50 €</li>
                    </ul>
                    <p class="info-text info-text--small">
                        Assurance annuelle compétition&nbsp;: <strong>90 €</strong>
                    </p>
                </article>
            </div>

            <div class="info-row info-row--bottom">
                <article class="info-block card info-block--accent">
                    <h2 class="info-title">Baby Boxe (5–9 ans)</h2>
                    <p class="info-text">
                        La Baby Boxe Initiation anglaise apprend les bases de la boxe
                        de manière ludique&nbsp;: coordination, garde, déplacements,
                        respect et confiance en soi.
                    </p>
                    <p class="info-text info-text--small">
                        Les séances sont encadrées, adaptées à l’âge, sans recherche de KO
                        ni mises en danger.
                    </p>
                </article>

                <article class="info-block card">
                    <h2 class="info-title">Perfectionnement & coaching</h2>
                    <ul class="info-list">
                        <li>
                            Cours de perfectionnement compétiteurs (sur demande) :
                            <strong>30 €</strong> la semaine
                        </li>
                        <li>
                            Coaching personnalisé (lun→ven, 10h–12h) :
                            <strong>50 €</strong> la semaine
                        </li>
                    </ul>
                    <p class="info-text info-text--small">
                        Idéal pour préparer un combat, travailler un point technique
                        ou reprendre confiance après une coupure.
                    </p>
                </article>
            </div>

            <div class="info-row info-row--full">
                <article class="info-faq card">
                    <h2 class="info-title">Questions fréquentes</h2>
                    <div class="faq-grid">
                        <div class="faq-item">
                            <h3>Puis-je payer en plusieurs fois ?</h3>
                            <p>
                                Oui, les formules indiquées “2×” peuvent être réglées en deux chèques
                                encaissés au cours de la saison. On voit ça ensemble lors de l’inscription.
                            </p>
                        </div>
                        <div class="faq-item">
                            <h3>Que se passe-t-il après le cours d’essai ?</h3>
                            <p>
                                Si tu t’inscris, le montant du cours d’essai est déduit de ta formule.
                                Sinon, tu ne dois rien de plus.
                            </p>
                        </div>
                        <div class="faq-item">
                            <h3>Faut-il un certificat médical ?</h3>
                            <p>
                                Oui, un certificat médical de non contre-indication à la pratique de la boxe
                                est demandé, et obligatoire.
                            </p>
                        </div>
                        <div class="faq-item">
                            <h3>Je ne sais pas quelle formule choisir…</h3>
                            <p>
                                Viens sur un cours d’essai, discute avec les coachs et on t’oriente vers la
                                formule la plus adaptée à ton niveau et tes objectifs.
                            </p>
                        </div>
                    </div>
                </article>
            </div>
        </section>

    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/pricing.js') }}" defer></script>
@endsection
