@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}?v=2">
@endsection

@section('content')
    {{-- HERO --}}
    <section class="hero-vid full-bleed full-bleed--nopad" aria-label="Présentation Team Bafounta">
        <div class="hero-vid__media" aria-hidden="true">
            <video id="heroVideo" class="hero-vid__video"
                   autoplay muted loop playsinline preload="metadata"
                   poster="{{ asset('assets/img/rayanayoub.jpeg') }}">
                {{-- Meilleur ordre : WEBM puis MP4 --}}
                <source src="{{ asset('assets/video/hero.webm') }}" type="video/webm">
                <source src="{{ asset('assets/video/video.mp4') }}" type="video/mp4">
            </video>

            <img class="hero-vid__fallback" src="{{ asset('assets/img/rayanayoub.jpeg') }}" alt="">
            <span class="hero-vid__overlay"></span>
            <span class="hero-vid__vignette"></span>
        </div>

        <div class="hero-vid__inner">
            <p class="hero-vid__kicker">Espace Ecole Sport Boxe</p>
            <h1 class="hero-vid__title">L’esprit <span class="accent">Team Bafounta</span></h1>
            <p class="hero-vid__lead">Ici, on tombe, on souffre, on se relève. <br>Parce que chaque coup nous rend plus fort, chaque entraînement nous rapproche de notre meilleure version. <br>Ici, on est une famille qui frappe fort.</p>
            <div class="hero-vid__actions">
                <a href="{{ route('enroll.step1') }}" class="btn btn-primary">Rejoindre la Team</a>
                <a href="{{ route('courses') }}" class="btn btn-ghost">Voir les horaires</a>
            </div>
            <ul class="hero-vid__badges" role="list">
                <li>Jamais seul. Jamais faible</li>
                <li>Courage. Respect. Combat</li>
                <li>Esprit guerrier</li>
            </ul>
        </div>

        <div class="hero-vid__scroll" aria-hidden="true">
            <span>Faire défiler</span><i></i>
        </div>
    </section>

    {{-- SECTION 2 — CTA --}}
    <section class="cta-simple full-bleed section section--cta" aria-labelledby="ctaJoinTitle">
        <div class="cta-s__grid">
            <div class="cta-s__left">
                <h2 id="ctaJoinTitle" class="cta-s__title">Rejoignez l’aventure Team Bafounta</h2>
                <p class="cta-s__lead">Depuis 2004, fondé par Aimé et Filip Bafounta, notre école de boxe à Vénissieux vous propose un cadre moderne, exigeant et humain — pour débutants, loisirs ou compétiteurs.</p>
                <a href="{{ route('enroll.step1') }}" class="btn btn-primary cta-s__btn">S’inscrire maintenant</a>
            </div>
            <div class="cta-s__right" aria-hidden="true">
                <figure class="media-card media-card--video media-card--fixbars"
                        style="--zoom:1.8; --shiftX:8%; --shiftY:22%;">
                    <video class="media-card__video" autoplay muted loop playsinline preload="metadata"
                           poster="{{ asset('assets/img/club-ambiance.jpg') }}">
                        <source src="{{ asset('assets/video/rayan.mp4') }}" type="video/mp4">
                    </video>
                    <figcaption class="media-card__badge">Team Bafounta – Vénissieux</figcaption>
                    <span class="media-card__glow"></span>
                </figure>

            </div>
        </div>
    </section>

    {{-- SECTION — Nos valeurs --}}
    <section class="values section full-bleed" aria-labelledby="valuesTitle">
        <div class="values__head container">
            <h2 id="valuesTitle" class="values__title">Nos valeurs</h2>
            <p class="values__intro">
                Ce qui nous définit au quotidien : exigence, respect et plaisir de transmettre.
            </p>
        </div>

        <div class="values__grid container">
            <!-- 1 -->
            <article class="val-card">
                <figure class="val-card__media">
                    <img src="{{ asset('assets/img/valeurs/aimemila.jpg') }}" alt="Séance technique avec un coach" loading="lazy">
                    <figcaption class="val-card__badge">Expertise reconnue</figcaption>
                </figure>
                <h3 class="val-card__title">Expertise reconnue</h3>
                <p class="val-card__text">
                    Nos entraîneurs, renommés dans le monde de la boxe, garantissent un enseignement de qualité.
                </p>
            </article>

            <!-- 2 -->
            <article class="val-card">
                <figure class="val-card__media">
                    <img src="{{ asset('assets/img/valeurs/fractionner.jpg') }}" alt="Ambiance de groupe pendant un entraînement" loading="lazy">
                    <figcaption class="val-card__badge">Partage de passion</figcaption>
                </figure>
                <h3 class="val-card__title">Partage de passion</h3>
                <p class="val-card__text">
                    Transmettre l’amour de la boxe et ses valeurs : respect de soi, des autres et des règles.
                </p>
            </article>

            <!-- 3 -->
            <article class="val-card">
                <figure class="val-card__media">
                    <img src="{{ asset('assets/img/valeurs/jeremyboxe.jpg') }}" alt="Athlète en progression au sac de frappe" loading="lazy">
                    <figcaption class="val-card__badge">Progression individuelle</figcaption>
                </figure>
                <h3 class="val-card__title">Progression individuelle</h3>
                <p class="val-card__text">
                    Chacun progresse à son rythme et dépasse ses limites, toujours dans la bienveillance.
                </p>
            </article>

            <!-- 4 -->
            <article class="val-card">
                <figure class="val-card__media">
                    <img src="{{ asset('assets/img/valeurs/jessroue.jpg') }}" alt="Sourires dans la salle, esprit d’équipe" loading="lazy">
                    <figcaption class="val-card__badge">Ambiance conviviale</figcaption>
                </figure>
                <h3 class="val-card__title">Ambiance conviviale</h3>
                <p class="val-card__text">
                    À l’Espace École Sport Boxe, on s’entraîne sérieusement, dans une ambiance chaleureuse et accueillante.
                </p>
            </article>
        </div>
    </section>

    {{-- SECTION — Nos membres --}}
    <section class="members section full-bleed" aria-labelledby="membersTitle">
        <div class="members__head container">
            <h2 id="membersTitle" class="members__title">Nos membres</h2>
            <p class="members__intro">Des trajectoires fortes, une même famille : Team Bafounta.</p>
        </div>

        <div class="members__grid container" role="list">

            {{-- Aimé Bafounta --}}
            <article class="m-card" role="listitem">
                <figure class="m-card__media">
                    <img src="{{ asset('assets/img/membres/aimebafounta.jpeg') }}" alt="Aimé Bafounta" loading="lazy" decoding="async">
                    <figcaption class="m-card__badge">Aimé Bafounta</figcaption>
                </figure>

                <div class="m-card__body">
                    <h3 class="m-card__name">Aimé Bafounta</h3>
                    <p class="m-card__meta">18 combats pro — 10 victoires (2 KO), 7 défaites, 1 nul.</p>

                    <button type="button" class="btn btn-ghost m-card__more" aria-expanded="false" data-target="aime">
                        En savoir plus
                    </button>

                    <div id="m-aime" class="m-card__details" hidden>
                        <ul>
                            <li>Coach principal & cofondateur de l’Espace École Sport Boxe.</li>
                            <li>Spécialités : technique, ringcraft, préparation mentale.</li>
                        </ul>
                    </div>
                </div>
            </article>

            {{-- Jérémy Peyronnet --}}
            <article class="m-card" role="listitem">
                <figure class="m-card__media">
                    <img src="{{ asset('assets/img/membres/jeremyboxe.jpg') }}" alt="Jérémy Peyronnet" loading="lazy" decoding="async">
                    <figcaption class="m-card__badge">Jérémy Peyronnet</figcaption>
                </figure>

                <div class="m-card__body">
                    <h3 class="m-card__name">Jérémy Peyronnet - Président</h3>
                    <p class="m-card__meta">15 combats amateur — 9 victoires (3 KO), 5 défaites, 1 nul.</p>

                    <button type="button" class="btn btn-ghost m-card__more" aria-expanded="false" data-target="jeremy">
                        En savoir plus
                    </button>

                    <div id="m-jeremy" class="m-card__details" hidden>
                        <ul>
                            <li>Encadrement des jeunes et boxe éducative.</li>
                            <li>Focus : cardio, déplacement, combinaisons.</li>
                        </ul>
                    </div>
                </div>
            </article>

            {{-- Filip Bafounta --}}
            <article class="m-card" role="listitem">
                <figure class="m-card__media">
                    <img src="{{ asset('assets/img/membres/filipbafounta.jpg') }}" alt="Filip Bafounta" loading="lazy" decoding="async">
                    <figcaption class="m-card__badge">Filip Bafounta</figcaption>
                </figure>

                <div class="m-card__body">
                    <h3 class="m-card__name">Filip Bafounta</h3>
                    <p class="m-card__meta">
                        Amateur : 45 combats (35 KO), 2 défaites. Pro : 48 combats (35 KO), 3 défaites.
                        Gant d’Or du meilleur Espoir, 3× vice-champion de France.
                    </p>

                    <button type="button" class="btn btn-ghost m-card__more" aria-expanded="false" data-target="filip">
                        En savoir plus
                    </button>

                    <div id="m-filip" class="m-card__details" hidden>
                        <ul>
                            <li>Coaching avancé : puissance, timing, finitions.</li>
                            <li>Accompagnement compétiteurs & sparring dirigé.</li>
                        </ul>
                    </div>
                </div>
            </article>

        </div>
    </section>

    {{-- SECTION — Notre histoire --}}
    {{-- SECTION — Notre histoire --}}
    <section class="history section full-bleed" aria-labelledby="historyTitle">
        <div class="history__grid container">
            <div class="history__left">
                <h2 id="historyTitle" class="history__title">Notre histoire<span class="accent">.</span></h2>
                <p class="history__intro">
                    Fondé en <strong>2004</strong> à Vénissieux par les frères <strong>Aimé</strong> et <strong>Filip Bafounta</strong>,
                    l’Espace École Sport Boxe est bien plus qu’un simple club : c’est un lieu de vie, de partage et de dépassement de soi.
                </p>

                <p class="history__text">
                    Ce qui a commencé comme une salle conviviale est devenu une véritable institution lyonnaise.
                    Année après année, la <strong>Team Bafounta</strong> a formé des générations de boxeurs, des jeunes débutants aux compétiteurs de haut niveau, dans un esprit de respect, d’exigence et de fraternité.
                </p>

                <p class="history__text">
                    Aujourd’hui, le club accueille des adhérents de <strong>5 à 70 ans</strong>, tous animés par la même passion.
                    Notre pédagogie allie rigueur, bienveillance et ambition, pour que chacun progresse à son rythme et trouve sa place sur le ring comme dans la vie.
                </p>

                <a href="{{ route('club') }}" class="btn btn-primary history__cta">Découvrir le club</a>
            </div>

            <div class="history__right" aria-hidden="true">
                <figure class="history__media">
                    <video class="history__video" autoplay muted loop playsinline preload="metadata"
                           poster="{{ asset('assets/img/club-histoire-poster.jpg') }}">
                        {{-- idéalement webm + mp4 --}}
                        {{-- <source src="{{ asset('assets/video/histoire.webm') }}" type="video/webm"> --}}
                        <source src="{{ asset('assets/video/filipaime.mp4') }}" type="video/mp4">
                    </video>
                    <figcaption>Depuis 2004 — Vénissieux</figcaption>
                </figure>
            </div>
        </div>

        <div class="history__numbers container" id="historyNumbers">
            <article>
                <strong class="counter" data-to="20" data-prefix="+"></strong>
                <span>ans de passion</span>
            </article>
            <article>
                <strong class="counter" data-to="1000" data-prefix="+"></strong>
                <span>adhérents formés</span>
            </article>
            <article>
                <strong class="counter" data-to="2"></strong>
                <span>frères fondateurs</span>
            </article>
        </div>
    </section>

    {{-- SECTION — Appel vers Prestations --}}
    <section class="cta-prestations section full-bleed" aria-labelledby="ctaPrestationsTitle">
        <div class="cta-prest__grid container">
            <div class="cta-prest__left">
                <h2 id="ctaPrestationsTitle" class="cta-prest__title">
                    Nos cours de boxe pour <span class="accent">tous les niveaux</span>
                </h2>
                <p class="cta-prest__text">
                    Que vous soyez débutant ou compétiteur, nos coachs adaptent chaque séance à votre rythme.
                    Découvrez des programmes variés, de l’aéroboxe loisir à la boxe amateur pour progresser,
                    transpirer et vous dépasser dans une ambiance conviviale.
                </p>
                <div class="cta-prest__actions">
                    <a href="{{ route('courses') }}" class="btn btn-primary">Découvrir nos cours et horaire</a>
                </div>
            </div>

            <div class="cta-prest__right" aria-hidden="true">
                <figure class="media-card media-card--video media-card--fixbars"
                        style="--zoom:1.5; --shiftX:0%; --shiftY:8%;">
                    <video class="media-card__video" autoplay muted loop playsinline preload="metadata"
                           poster="{{ asset('assets/img/enfants.jpeg') }}">
                        <source src="{{ asset('assets/video/entrainement2.mp4') }}" type="video/mp4">
                    </video>
                    <figcaption class="media-card__badge">Team Bafounta — En action</figcaption>
                    <span class="media-card__glow"></span>
                </figure>
            </div>
        </div>
    </section>

    {{-- SECTION — Partenaires (double bande avec fallback d’extensions) --}}
    <section class="partners section full-bleed" aria-labelledby="partnersTitle">
        <div class="container">
            <h2 id="partnersTitle" class="partners__title">Ils nous soutiennent</h2>
            <p class="partners__subtitle">Partenaires officiels & soutiens institutionnels</p>
        </div>

        {{-- Row A : défilement gauche --}}
        <div class="partners__marquee" aria-label="Logos partenaires (ligne 1)">
            <ul class="partners__track partners__track--a" style="--speed: 38s;">
                {{-- 1er passage --}}
                <li class="partners__item"><a class="partners__link" href="https://www.oms-venissieux.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/oms') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="OMS Vénissieux"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.creditmutuel.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/creditmutuel') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Crédit Mutuel"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.auvergnerhonealpes.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/region') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Région Auvergne-Rhône-Alpes"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://matos2boxe.com" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/matos') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Matos2Boxe"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.grandlyon.com" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/metropole') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Métropole de Lyon"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.ffboxe.com" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/ffboxe') }}" data-fallback-exts="jpg,png,jpeg,webp" alt="Fédération Française de Boxe"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.lerondpointvenissieux.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/lerondpoint') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Le Rond Point"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.ville-venissieux.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/venissieux') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Ville de Vénissieux"></a></li>

                {{-- 2e passage (dupliqué pour boucle) --}}
                <li class="partners__item"><a class="partners__link" href="https://www.oms-venissieux.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/oms') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="OMS Vénissieux"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.creditmutuel.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/creditmutuel') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Crédit Mutuel"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.auvergnerhonealpes.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/region') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Région Auvergne-Rhône-Alpes"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://matos2boxe.com" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/matos') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Matos2Boxe"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.grandlyon.com" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/metropole') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Métropole de Lyon"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.ffboxe.com" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/ffboxe') }}" data-fallback-exts="jpg,png,jpeg,webp" alt="Fédération Française de Boxe"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.lerondpointvenissieux.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/lerondpoint') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Le Rond Point"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.ville-venissieux.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/venissieux') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Ville de Vénissieux"></a></li>
            </ul>
        </div>

        {{-- Row B : défilement droite (reverse) --}}
        <div class="partners__marquee partners__marquee--b" aria-label="Logos partenaires (ligne 2)">
            <ul class="partners__track partners__track--b" style="--speed: 42s;">
                {{-- 1er passage --}}
                <li class="partners__item"><a class="partners__link" href="https://www.creditmutuel.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/creditmutuel') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Crédit Mutuel"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.auvergnerhonealpes.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/region') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Région Auvergne-Rhône-Alpes"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.grandlyon.com" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/metropole') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Métropole de Lyon"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.ffboxe.com" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/ffboxe') }}" data-fallback-exts="jpg,png,jpeg,webp" alt="Fédération Française de Boxe"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.oms-venissieux.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/oms') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="OMS Vénissieux"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.ville-venissieux.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/venissieux') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Ville de Vénissieux"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://matos2boxe.com" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/matos') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Matos2Boxe"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.lerondpointvenissieux.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/lerondpoint') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Le Rond Point"></a></li>

                {{-- 2e passage (dupliqué) --}}
                <li class="partners__item"><a class="partners__link" href="https://www.creditmutuel.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/creditmutuel') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Crédit Mutuel"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.auvergnerhonealpes.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/region') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Région Auvergne-Rhône-Alpes"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.grandlyon.com" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/metropole') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Métropole de Lyon"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.ffboxe.com" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/ffboxe') }}" data-fallback-exts="jpg,png,jpeg,webp" alt="Fédération Française de Boxe"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.oms-venissieux.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/oms') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="OMS Vénissieux"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.ville-venissieux.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/venissieux') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Ville de Vénissieux"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://matos2boxe.com" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/matos') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Matos2Boxe"></a></li>
                <li class="partners__item"><a class="partners__link" href="https://www.lerondpointvenissieux.fr" target="_blank" rel="noopener nofollow"><img loading="lazy" data-base="{{ asset('assets/img/partners/lerondpoint') }}" data-fallback-exts="png,jpg,jpeg,webp" alt="Le Rond Point"></a></li>
            </ul>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/home.js') }}" defer></script>
@endsection
