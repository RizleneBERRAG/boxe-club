@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/club.css') }}?v=3">
@endsection

@section('content')
    {{-- INTRO LOGO (overlay) — commun à toutes les pages --}}
    <section class="logo-intro" aria-hidden="true">
        <div class="logo-intro__inner">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Team Bafounta">
        </div>
        {{-- Fallback sans JS : masquer l’overlay --}}
        <noscript>
            <style>.logo-intro{display:none!important}</style>
        </noscript>
    </section>

    <main class="page-club">
        {{-- HERO VIDÉO — Le club --}}
        <section class="hero-vid hero-vid--club full-bleed full-bleed--nopad" aria-label="Le club">
            <figure class="hero-vid__media" aria-hidden="true">
                <video class="hero-vid__video" autoplay muted loop playsinline preload="metadata"
                       poster="{{ asset('assets/img/club/ancienlogo.jpg') }}">
                    {{-- Idéal : WebM en premier si dispo --}}
                    {{-- <source src="{{ asset('assets/video/ayoub/ayoubring.webm') }}" type="video/webm"> --}}
                    {{-- Fallback universel --}}
                    <source src="{{ asset('assets/video/ayoub/ayoubaime.mp4') }}" type="video/mp4">
                    {{-- Si tu gardes un .mov (optionnel) --}}
                    {{-- <source src="{{ asset('assets/video/ayoub/ayoubaime.mov') }}" type="video/quicktime"> --}}
                </video>
                <span class="hero-vid__overlay"></span>
                <span class="hero-vid__vignette"></span>

                <noscript>
                    <img src="{{ asset('assets/img/club/ancienlogo.jpg') }}"
                         alt="Espace École Sport Boxe — Team Bafounta">
                </noscript>
            </figure>

            <div class="hero-vid__inner">
                {{-- Bouton mute/unmute du hero --}}
                <button type="button" class="hero-sound" aria-pressed="false" aria-label="Activer le son">
                    <span class="hero-sound__icon hero-sound__icon--off" aria-hidden="true">🔇</span>
                    <span class="hero-sound__icon hero-sound__icon--on" aria-hidden="true">🔊</span>
                </button>

                <p class="hero-vid__kicker reveal">Notre Club</p>
                <h1 class="hero-vid__title reveal">La Team Bafounta</h1>
                <p class="hero-vid__lead reveal">Une école, une famille, une passion.</p>
                <div class="hero-vid__actions reveal" aria-live="polite">
                    <a href="{{ route('enroll.step1') }}" class="btn btn-primary">Rejoindre la Team !</a>
                    <a href="{{ route('courses') }}" class="btn btn-ghost">Voir les horaires</a>
                </div>
            </div>

            <div class="hero-vid__scroll" aria-hidden="true">
                <span>Faire défiler</span><i></i>
            </div>
        </section>

        {{-- SECTION 1 — Valeurs (cartes tilt) --}}
        <section id="spirit" class="section club-values full-bleed" aria-labelledby="valuesTitle">
            <div class="container">
                <header class="values-head">
                    <h2 id="valuesTitle" class="values-title reveal">L’esprit Team Bafounta</h2>
                    <p class="values-intro reveal">
                        Un lieu de passion, d’exigence et de transmission. Ici, on progresse ensemble — du premier jab aux combats.
                    </p>
                </header>

                <ul class="v-grid" role="list">
                    <li class="v-card reveal" data-tilt>
                        <div class="v-chip">💪 Exigence</div>
                        <h3 class="v-title">Le goût de l’effort</h3>
                        <p class="v-text">Sérieux à l’entraînement, respect sur le ring. On construit la technique et le mental, round après round.</p>
                    </li>

                    <li class="v-card reveal" data-tilt>
                        <div class="v-chip">🤝 Fraternité</div>
                        <h3 class="v-title">Un club, une famille</h3>
                        <p class="v-text">On s’encourage, on se tire vers le haut. Chacun trouve sa place, du loisir à la compétition.</p>
                    </li>

                    <li class="v-card reveal" data-tilt>
                        <div class="v-chip">🔥 Transmission</div>
                        <h3 class="v-title">Partager l’expérience</h3>
                        <p class="v-text">Depuis 2004, la Team Bafounta transmet une culture : rigueur, humilité, persévérance.</p>
                    </li>

                    <li class="v-card reveal" data-tilt>
                        <div class="v-chip">🎯 Progression</div>
                        <h3 class="v-title">Des objectifs clairs</h3>
                        <p class="v-text">Des repères simples, un suivi concret. Le progrès se mesure, et se célèbre.</p>
                    </li>
                </ul>
            </div>
        </section>

        {{-- SECTION 2 — Studio (split média/texte) --}}
        <section id="studio" class="section studio-split full-bleed" aria-labelledby="studioTitle">
            <div class="studio-wrap">
                {{-- Colonne Média --}}
                <aside class="studio-media" aria-label="Ambiance dans la salle">
                    <video class="studio-video" autoplay muted loop playsinline preload="metadata"
                           poster="{{ asset('assets/img/club/hero-poster.jpg') }}">
                        <source src="{{ asset('assets/video/club-hero.mp4') }}" type="video/mp4">
                    </video>
                    {{-- <img class="studio-image" src="{{ asset('assets/img/club/gal1.jpg') }}" alt="La salle Team Bafounta" loading="lazy"> --}}
                    <div class="studio-media__overlay"></div>
                </aside>

                {{-- Colonne Texte --}}
                <div class="studio-content">
                    <header class="studio-head">
                        <h2 id="studioTitle" class="studio-title reveal">Dans la salle</h2>
                        <p class="studio-intro reveal">Une ambiance de travail, des rituels simples, et l’énergie qui te fait revenir.</p>
                    </header>

                    <article class="studio-block reveal" data-parallax>
                        <h3 class="studio-block__title">Échauffement intelligent</h3>
                        <p class="studio-block__text">Mobilité, gainage, coordination — on prépare le corps pour boxer mieux et plus longtemps.</p>
                    </article>

                    <article class="studio-block reveal" data-parallax>
                        <h3 class="studio-block__title">Technique & placements</h3>
                        <p class="studio-block__text">Angles, appuis, distance : la science des petits détails qui changent tout sur le ring.</p>
                    </article>

                    <article class="studio-block reveal" data-parallax>
                        <h3 class="studio-block__title">Mises de gants</h3>
                        <p class="studio-block__text">Contrôle, respect et intention. On met en pratique sans perdre la tête.</p>
                    </article>

                    <article class="studio-block reveal" data-parallax>
                        <h3 class="studio-block__title">Conditioning</h3>
                        <p class="studio-block__text">Sacs lourds, corde, renfo. On construit un moteur solide, au service de la technique.</p>
                    </article>

                    <div class="studio-cta reveal">
                        <a href="{{ route('enroll.step1') }}" class="btn btn-primary">Nous rejoindre !</a>
                        <a href="{{ route('courses') }}" class="btn btn-ghost">Nous contacter</a>
                    </div>
                </div>
            </div>
        </section>

        {{-- SECTION 3 — Timeline (histoire) --}}
        <section id="history" class="section club-timeline full-bleed" aria-labelledby="timelineTitle">
            <div class="container">
                <header class="timeline-head">
                    <h2 id="timelineTitle" class="timeline-title reveal">Notre histoire</h2>
                    <p class="timeline-intro reveal">Des débuts modestes à une équipe reconnue, la Team Bafounta a toujours boxé avec le cœur.</p>
                </header>

                <ul class="timeline-list" role="list">
                    <li class="timeline-item reveal">
                        <div class="t-year"></div>
                        <div class="t-content">
                            <h3 class="t-title">Création du club</h3>
                            <p class="t-text">Tout commence dans un petit local à Vénissieux. Une salle, quelques sacs, et une ambition : faire aimer la boxe à tous.</p>
                        </div>
                        <figure class="t-media">
                            <img src="{{ asset('assets/img/club/old1.jpg') }}" alt="Débuts du club" loading="lazy">
                        </figure>
                    </li>

                    <li class="timeline-item reveal">
                        <div class="t-year"></div>
                        <div class="t-content">
                            <h3 class="t-title">Premiers titres régionaux</h3>
                            <p class="t-text">Les boxeurs de la Team Bafounta commencent à marquer les compétitions locales — discipline et passion au centre du ring.</p>
                        </div>
                        <figure class="t-media">
                            <img src="{{ asset('assets/img/club/old2.jpg') }}" alt="Premiers combats officiels" loading="lazy">
                        </figure>
                    </li>

                    <li class="timeline-item reveal">
                        <div class="t-year"></div>
                        <div class="t-content">
                            <h3 class="t-title">Nouveau local, nouvelle ère</h3>
                            <p class="t-text">Une salle plus grande, plus de licenciés, plus de rêves. Le club devient une référence dans la région lyonnaise.</p>
                        </div>
                        <figure class="t-media">
                            <img src="{{ asset('assets/img/club/old3.jpg') }}" alt="Nouveaux locaux" loading="lazy">
                        </figure>
                    </li>

                    <li class="timeline-item reveal">
                        <div class="t-year"></div>
                        <div class="t-content">
                            <h3 class="t-title">Toujours plus haut</h3>
                            <p class="t-text">La Team Bafounta, c’est désormais une école, une famille et une fierté. Le meilleur reste à venir.</p>
                        </div>
                        <figure class="t-media">
                            <img src="{{ asset('assets/img/club/hero-poster.jpg') }}" alt="Team actuelle" loading="lazy">
                        </figure>
                    </li>
                </ul>
            </div>
        </section>
    </main>

    <section class="section club-cta full-bleed" aria-label="Rejoindre la Team">
        <div class="club-cta__wrap">
            <h2 class="club-cta__title reveal">Prêt à monter sur le ring ?</h2>
            <p class="club-cta__text reveal">Que tu sois débutant ou compétiteur, rejoins la Team Bafounta et découvre ta vraie force.</p>
            <div class="club-cta__actions reveal">
                <a href="{{ route('enroll.step1') }}" class="btn btn-primary">S’inscrire maintenant</a>
                <a href="{{ route('courses') }}" class="btn btn-ghost">Voir les horaires</a>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/club.js') }}?v=3" defer></script>
@endsection
