@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pricing.css') }}">
@endsection

@section('content')
    @php
        $plans = \App\Models\Plan::where('is_active',1)->orderBy('price_cents')->get();
        $count = $plans->count();
        $recommendedIndex = max(0, (int) floor(($count-1)/2));
    @endphp

    <section class="section">
        <h1 class="page-title">Tarifs & Adhésions</h1>

        {{-- Cours d’essai (déduit à l’inscription) --}}
        <div class="notice card">
            <div class="dot"></div>
            <div>
                <strong>Cours d’essai :</strong> 30 € (boxe éducative) — 50 € (boxe amateur).
                <em>Ces frais sont <u>déduits</u> lors de l’inscription.</em>
            </div>
        </div>

        @if($plans->isNotEmpty())
            <div class="pricing-grid">
                @foreach($plans as $i => $p)
                    @php
                        $isRec = $i === $recommendedIndex;
                        $price = number_format($p->price_cents/100, 2, ',', ' ');
                    @endphp

                    <article class="price-card card {{ $isRec ? 'is-featured' : '' }}" data-reveal>
                        @if($isRec)<div class="badge">Populaire</div>@endif

                        <h2 class="title">{{ $p->name }}</h2>

                        <div class="price-row">
                            <span class="currency">€</span>
                            <span class="amount">{{ str_replace([',',' '], ['.',' '], $price) }}</span>
                            <span class="period">/ saison</span>
                        </div>

                        @if($p->allow_split)
                            <p class="split">ou en 2× : <strong>{{ number_format(($p->price_cents/2)/100, 2, ',', ' ') }} €</strong></p>
                        @endif

                        @if($p->description)<p class="desc">{{ $p->description }}</p>@endif

                        <ul class="features">
                            <li>Accès aux cours inclus</li>
                            <li>Encadrement diplômé</li>
                            <li>Licence & assurance selon formule</li>
                        </ul>

                        <a class="btn btn-primary cta" href="{{ route('enroll.step1') }}">Choisir cette formule</a>
                    </article>
                @endforeach
            </div>
        @else
            <div class="card muted">Les formules seront publiées prochainement.</div>
        @endif

        {{-- Équipement --}}
        <div class="card info-block">
            <h2 class="sub">Équipement (obligatoire)</h2>
            <p class="muted">Équipement réglementaire complet — se renseigner auprès du club.</p>
            <ul class="prices">
                <li><strong>Pack complet nouveaux adhérents</strong> : 150 € (boxe éducative) • 200 € (boxe amateur)</li>
                <li><strong>Tenue seule</strong> : 60 € (éducative) • 90 € (amateur)</li>
            </ul>
        </div>

        {{-- Assurances déplacements compétitions --}}
        <div class="card info-block">
            <h2 class="sub">Assurance compétitions — forfait déplacement</h2>
            <ul class="prices">
                <li>Région lyonnaise : 12 €</li>
                <li>Hors région ≤ 150 km : 30 €</li>
                <li>> 150 km : 50 €</li>
            </ul>
            <p class="muted">Assurance annuelle : <strong>90 €</strong></p>
        </div>

        {{-- Coaching / Perfectionnement --}}
        <div class="card info-block">
            <h2 class="sub">Perfectionnement & Coaching</h2>
            <ul class="prices">
                <li>Cours de perfectionnement compétiteurs (sur demande) : <strong>30 €</strong> la semaine</li>
                <li>Coaching personnalisé (lun→ven, 10h–12h) : <strong>50 €</strong> la semaine</li>
            </ul>
        </div>

        {{-- Baby Boxe : explication --}}
        <div class="card info-block">
            <h2 class="sub">Baby Boxe Initiation</h2>
            <p>La Baby Boxe Initiation anglaise (5–9 ans) enseigne la boxe de façon ludique et sécurisée, en travaillant la coordination et la confiance.</p>
        </div>

        <div class="cta-row">
            <a class="btn btn-primary" href="{{ route('enroll.step1') }}">Séance d’essai gratuite</a>
            <a class="link" href="{{ route('courses') }}">Voir les horaires</a>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/pricing.js') }}" defer></script>
@endsection
