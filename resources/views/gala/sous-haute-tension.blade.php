<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sous Haute Tension – Gala Team Bafounta</title>

    {{-- Font moderne --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,600,700" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/css/sous-haute-tension.css') }}?v=3">
</head>
<body class="page-gala">

{{-- INTRO LOGO FULLSCREEN --}}
<div class="logo-intro" id="logoIntro">
    <div class="logo-intro__inner">
        <img
            src="{{ asset('assets/img/logo.png') }}"
            alt="Team Bafounta"
            class="logo-intro__logo"
        >
        <p class="logo-intro__tagline">Team Bafounta présente</p>
    </div>
</div>

{{-- Barre de progression de scroll --}}
<div class="scroll-progress" id="scrollProgress"></div>

{{-- Navbar sticky futuriste --}}
<header class="top-nav" id="topNav">
    <div class="top-nav__inner">
        <div class="top-nav__brand">
            <div class="top-nav__logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Team Bafounta">
            </div>
            <div class="top-nav__brand-text">
                <span class="brand-pill">Team Bafounta</span>
                <span class="brand-event">Sous Haute Tension</span>
            </div>
        </div>
        <nav class="top-nav__links">
            <a href="#infos">L’expérience</a>
            <a href="#tombola">Tombola</a>
            <a href="#billetterie">Billetterie</a>
            <a href="#sponsors">Partenaires</a>
        </nav>

        <a href="#billetterie" class="btn btn-primary btn-nav">Réserver</a>
    </div>
</header>

{{-- BACKGROUND GLOBAL (grille + particules) --}}
<div class="bg-grid"></div>
<div class="bg-noise"></div>

{{-- HERO FULLSCREEN --}}
<section class="hero" id="top">
    {{-- Logo géant en watermark derrière le titre --}}
    <div class="hero-logo-mark hero-layer" data-depth="0.08">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Team Bafounta">
    </div>

    <div class="hero-video-wrap hero-layer" data-depth="0.15">
        <video class="hero-video" autoplay muted loop playsinline preload="metadata"
               poster="{{ asset('assets/img/logo.png') }}">
            <source src="{{ asset('assets/video/video.mp4') }}" type="video/mp4">
        </video>
        <div class="hero-gradient"></div>
    </div>

    <div class="hero-inner hero-layer" data-depth="0.35">
        <p class="hero-kicker">Gala de boxe</p>

        <h1 class="hero-title">
                <span class="hero-title-main" data-text="SOUS HAUTE TENSION">
                    SOUS HAUTE TENSION
                </span>
        </h1>

        <p class="hero-meta">
            Team Bafounta • Gymnase Jacques Anquetil • 23 novembre 2024
        </p>

        <div class="hero-actions">
            <a href="#billetterie" class="btn btn-primary">Réserver maintenant</a>
            <a href="#infos" class="btn btn-ghost">En savoir plus</a>
        </div>

        {{-- Compte à rebours --}}
        <div class="hero-countdown" id="countdown">
            <div class="cd-item">
                <span class="cd-value" data-unit="days">00</span>
                <small>Jours</small>
            </div>
            <div class="cd-item">
                <span class="cd-value" data-unit="hours">00</span>
                <small>Heures</small>
            </div>
            <div class="cd-item">
                <span class="cd-value" data-unit="minutes">00</span>
                <small>Minutes</small>
            </div>
            <div class="cd-item">
                <span class="cd-value" data-unit="seconds">00</span>
                <small>Secondes</small>
            </div>
        </div>
    </div>

    <div class="hero-scroll">
        <span>Faire défiler</span>
        <i></i>
    </div>
</section>

{{-- SECTION INFOS --}}
<section id="infos" class="section section-infos">
    <div class="section-inner">
        <header class="section-head reveal">
            <h2 class="section-title">Une soirée sous haute tension</h2>
            <p class="section-intro">
                12 combats, dont 2 combats professionnels, tables VIP, buvette, snack, tombola…
                Une ambiance électrique au cœur de Vénissieux.
            </p>
        </header>

        <ul class="info-grid" role="list">
            <li class="info-card reveal tilt">
                <h3>Combats</h3>
                <p>12 affrontements soigneusement matchés, avec 2 combats pros pour clôturer la soirée.</p>
            </li>
            <li class="info-card reveal tilt">
                <h3>Public</h3>
                <p>Jusqu’à 300 spectateurs : ring-side, tribunes et espace VIP.</p>
            </li>
            <li class="info-card reveal tilt">
                <h3>Ambiance</h3>
                <p>Son, lumières, entrées boxeurs, mise en scène inspirée des plus grands shows.</p>
            </li>
            <li class="info-card reveal tilt">
                <h3>Confort</h3>
                <p>Tables VIP avec repas complet, buvette, snack partenaire, tombola et surprises.</p>
            </li>
        </ul>
    </div>
</section>

{{-- SECTION TOMBOLA --}}
<section id="tombola" class="section section-tombola">
    <div class="section-inner tombola-inner">
        <header class="section-head reveal">
            <h2 class="section-title">Tombola du gala</h2>
            <p class="section-intro">
                Une tombola 100% boxe pour soutenir la Team Bafounta et repartir, peut-être, avec un équipement complet.
            </p>
        </header>

        <div class="tombola-layout">
            <div class="tombola-main reveal tilt">
                <h3 class="tombola-title">Lots à gagner</h3>
                <ul class="tombola-list">
                    <li>
                        <strong>Lot 1&nbsp;:</strong>
                        Tenue de boxe complète <em>Team Bafounta</em> (gants, short, t-shirt / débardeur)
                        avec le nouveau logo, en avant-première.
                    </li>
                    <li>
                        <strong>Lot 2&nbsp;:</strong>
                        Pack “experience ring-side” pour un prochain événement (places au bord du ring + accès coulisses*).
                    </li>
                    <li>
                        <strong>Lot 3&nbsp;:</strong>
                        Pack entraînement : séance de coaching ou stage avec la Team Bafounta*.
                    </li>
                </ul>
                <p class="tombola-note">
                    *Les modalités précises (date, horaires) seront définies directement avec le club.
                </p>
            </div>

            <aside class="tombola-aside reveal tilt">
                <div class="tombola-badge">Tombola en ligne &amp; sur place</div>
                <p class="tombola-text">
                    Tu pourras acheter tes tickets directement au gala, et prochainement
                    <strong>en ligne depuis cette page</strong>.
                </p>

                <div class="tombola-info-row">
                    <div>
                        <span class="tombola-label">Prix du ticket</span>
                        <span class="tombola-value">5 €</span>
                    </div>
                    <div>
                        <span class="tombola-label">Acheter</span>
                        <span class="tombola-value">Sur place &mdash; bientôt en ligne</span>
                    </div>
                </div>

                <button class="btn btn-primary btn-small" disabled>
                    Achat en ligne bientôt disponible
                </button>
            </aside>
        </div>
    </div>
</section>

{{-- SECTION BILLETTERIE --}}
<section id="billetterie" class="section section-tickets">
    <div class="section-inner">
        <header class="section-head reveal">
            <h2 class="section-title">Billetterie</h2>
            <p class="section-intro">
                Choisis ton expérience — paiement sécurisé en ligne, places limitées.
            </p>
        </header>

        <div class="tickets-grid" role="list">
            <article class="ticket-card ticket-ring reveal tilt">
                <div class="ticket-tag">Immersion totale</div>
                <h3>Au bord du ring</h3>
                <p class="ticket-price">50 €</p>
                <p class="ticket-text">Les gouttes de sueur, les impacts, l’ambiance… juste là, sous tes yeux.</p>
                <button class="btn btn-primary btn-small" disabled>Bientôt disponible</button>
            </article>

            <article class="ticket-card ticket-tribune reveal tilt">
                <div class="ticket-tag">Vue globale</div>
                <h3>Tribune</h3>
                <p class="ticket-price">25 €</p>
                <p class="ticket-text">Une vision parfaite de l’ensemble du ring et du show.</p>
                <button class="btn btn-primary btn-small" disabled>Bientôt disponible</button>
            </article>

            <article class="ticket-card ticket-enfant reveal tilt">
                <div class="ticket-tag">Jeunes</div>
                <h3>Enfant (-12 ans)</h3>
                <p class="ticket-price">10 €</p>
                <p class="ticket-text">Pour vivre le gala en famille, en tribune.</p>
                <button class="btn btn-primary btn-small" disabled>Bientôt disponible</button>
            </article>

            <article class="ticket-card ticket-vip reveal tilt">
                <div class="ticket-tag">Expérience complète</div>
                <h3>Table VIP (x5)</h3>
                <p class="ticket-price">500 €</p>
                <p class="ticket-text">
                    Table de 5 personnes, repas complet, service à table, vue privilégiée sur le ring.
                </p>
                <button class="btn btn-primary btn-small" disabled>Bientôt disponible</button>
            </article>
        </div>
        <div class="share-bar reveal">
            <div class="share-text">
                Partage la soirée avec tes proches et ramène ta team 🔥
            </div>
            <button class="btn btn-ghost btn-small" id="shareButton">
                Partager la page
            </button>
        </div>

    </div>
    {{-- SECTION SPONSORS --}}
    <section id="sponsors" class="section section-sponsors">
        <div class="section-inner">
            <header class="section-head reveal">
                <h2 class="section-title">Partenaires &amp; soutiens</h2>
                <p class="section-intro">
                    Le gala <strong>Sous Haute Tension</strong> est rendu possible grâce au soutien de nos partenaires.
                </p>
            </header>

            <div class="sponsors-grid" role="list">
                <article class="sponsor-card reveal tilt">
                    <div class="sponsor-logo">
                        <img src="{{ asset('assets/img/partners/creditmutuel.png') }}" alt="Crédit Mutuel">
                    </div>
                    <h3>Crédit Mutuel</h3>
                    <p>Partenaire financier du gala et soutien du sport local.</p>
                </article>

                <article class="sponsor-card reveal tilt">
                    <div class="sponsor-logo">
                        <img src="{{ asset('assets/img/partners/region.png') }}" alt="Région Auvergne Rhône-Alpes">
                    </div>
                    <h3>Région Auvergne Rhône-Alpes</h3>
                    <p>Un appui institutionnel pour faire vivre la boxe en région.</p>
                </article>

                <article class="sponsor-card reveal tilt">
                    <div class="sponsor-logo">
                        <img src="{{ asset('assets/img/partners/ffboxe.jpg') }}" alt="Fédération Française de Boxe">
                    </div>
                    <h3>Fédération Française de Boxe</h3>
                    <p>Un cadre officiel et une reconnaissance fédérale de l’événement.</p>
                </article>

                <article class="sponsor-card reveal tilt">
                    <div class="sponsor-logo">
                        <img src="{{ asset('assets/img/partners/rd.png') }}" alt="RD Boxing">
                    </div>
                    <h3>RD Boxing</h3>
                    <p>Équipementier boxe : matériel et image pour un gala de haut niveau.</p>
                </article>
            </div>
        </div>
    </section>


</section>

<script src="{{ asset('assets/js/sous-haute-tension.js') }}?v=2" defer></script>
</body>
</html>
