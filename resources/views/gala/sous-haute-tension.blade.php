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
        <img src="{{ asset('assets/img/logo.png') }}" alt="Team Bafounta" class="logo-intro__logo">
        <p class="logo-intro__tagline">Team Bafounta présente</p>
    </div>
</div>

{{-- Barre de progression de scroll --}}
<div class="scroll-progress" id="scrollProgress"></div>

{{-- Navbar --}}
<header class="top-nav" id="topNav">
    <div class="top-nav__inner">
        <div class="top-nav__brand">
            <div class="top-nav__logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Team Bafounta">
            </div>
            <div class="top-nav__brand-text">
                <span class="brand-pill">Team Bafounta</span>
            </div>
        </div>

        <nav class="top-nav__links">
            <a href="#infos">L’expérience</a>
            <a href="#tombola">Tombola</a>
            <a href="#billetterie">Billetterie</a>
            <a href="#sponsors">Partenaires</a>
        </nav>

        <a href="#billetterie" class="btn btn-primary btn-nav">Sous Haute Tension</a>
    </div>
</header>

{{-- Background FX --}}
<div class="bg-grid"></div>
<div class="bg-noise"></div>

{{-- HERO --}}
<section class="hero" id="top">

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
            <span class="hero-title-main" data-text="SOUS HAUTE TENSION">SOUS HAUTE TENSION</span>
        </h1>

        <p class="hero-meta">
            Team Bafounta • Gymnase Jacques Anquetil • 19 décembre 2025 – 16h00
        </p>

        <div class="hero-actions">
            <a href="#billetterie" class="btn btn-primary">Réserver maintenant</a>
            <a href="#infos" class="btn btn-ghost">En savoir plus</a>
        </div>

        {{-- Compte à rebours --}}
        <div class="hero-countdown" id="countdown">
            <div class="cd-item"><span class="cd-value" data-unit="days">00</span><small>Jours</small></div>
            <div class="cd-item"><span class="cd-value" data-unit="hours">00</span><small>Heures</small></div>
            <div class="cd-item"><span class="cd-value" data-unit="minutes">00</span><small>Minutes</small></div>
            <div class="cd-item"><span class="cd-value" data-unit="seconds">00</span><small>Secondes</small></div>
        </div>
    </div>

    <div class="hero-scroll">
        <span>Faire défiler</span><i></i>
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
            <li class="info-card reveal tilt"><h3>Combats</h3><p>12 affrontements matchés, dont 2 pros.</p></li>
            <li class="info-card reveal tilt"><h3>Public</h3><p>Ring-side, tribunes et espace VIP.</p></li>
            <li class="info-card reveal tilt"><h3>Ambiance</h3><p>Show lumière, musique, entrées boxeurs.</p></li>
            <li class="info-card reveal tilt"><h3>Confort</h3><p>Tables VIP, repas complet, animations.</p></li>
        </ul>
    </div>
</section>

{{-- SECTION TOMBOLA --}}
<section id="tombola" class="section section-tombola">
    <div class="section-inner tombola-inner">

        <header class="section-head reveal">
            <h2 class="section-title">Tombola du gala</h2>
            <p class="section-intro">Une tombola 100% boxe pour soutenir le club.</p>
        </header>

        <div class="tombola-layout">
            <div class="tombola-main reveal tilt">
                <br>
                <h3 class="tombola-title">Lots à gagner</h3>
                <br>
                <ul class="tombola-list">
                    <li><strong>Lot 1 :</strong> Tenue complète Team Bafounta (nouveau logo).</li>
                    <li><strong>Lot 2 :</strong> Pack “Experience ring-side”.</li>
                    <li><strong>Lot 3 :</strong> Coaching / stage avec le club.</li>
                </ul>
                <br>
                <p class="tombola-note">* Dates définies avec le club.</p>
            </div>

            <aside class="tombola-aside reveal tilt">
                <div class="tombola-badge">En ligne & sur place</div>
                <p class="tombola-text">
                    Tickets disponibles au gala, et bientôt <strong>en ligne</strong>.
                </p>

                <div class="tombola-info-row">
                    <div><span class="tombola-label">Prix du ticket</span><span class="tombola-value">5 €</span></div>
                    <div><span class="tombola-label">Achat</span><span class="tombola-value">Sur place — bientôt en ligne</span></div>
                </div>

                <button class="btn btn-primary btn-small" disabled>Achat en ligne bientôt disponible</button>
            </aside>
        </div>
    </div>
</section>

{{-- SECTION BILLETTERIE --}}
<section id="billetterie" class="section section-tickets">
    <div class="section-inner">

        <header class="section-head reveal">
            <h2 class="section-title">Billetterie</h2>
            <p class="section-intro">Paiement sécurisé — places limitées.</p>
        </header>

        <div class="tickets-grid">

            {{-- RING --}}
            <article class="ticket-card ticket-ring reveal tilt">
                <div class="ticket-tag">Immersion totale</div>
                <h3>Au bord du ring</h3>
                <p class="ticket-price">30 €</p>
                <p class="ticket-text">Les impacts, l'intensité… à quelques centimètres.</p>
                <div class="ticket-actions">
                    <button class="btn btn-primary btn-small js-add-ticket" data-ticket="ring">+</button>
                    <button class="btn btn-ghost btn-small js-remove-ticket" data-ticket="ring">–</button>
                </div>
                <p class="ticket-qty-text">
                    Dans le panier : <span class="js-ticket-qty" data-ticket="ring">0</span>
                </p>
            </article>

            {{-- TRIBUNE --}}
            <article class="ticket-card ticket-tribune reveal tilt">
                <div class="ticket-tag">Vue globale</div>
                <h3>Tribune</h3>
                <p class="ticket-price">15 €</p>
                <p class="ticket-text">Une vision parfaite du show et du ring.</p>
                <div class="ticket-actions">
                    <button class="btn btn-primary btn-small js-add-ticket" data-ticket="tribune">+</button>
                    <button class="btn btn-ghost btn-small js-remove-ticket" data-ticket="tribune">–</button>
                </div>
                <p class="ticket-qty-text">
                    Dans le panier : <span class="js-ticket-qty" data-ticket="tribune">0</span>
                </p>
            </article>

            {{-- ENFANT --}}
            <article class="ticket-card ticket-enfant reveal tilt">
                <div class="ticket-tag">Jeunes</div>
                <h3>Enfant (-12 ans)</h3>
                <p class="ticket-price">10 €</p> {{-- mets 0 € si tu veux tester gratos --}}
                <p class="ticket-text">Pour vivre le gala en famille.</p>
                <div class="ticket-actions">
                    <button class="btn btn-primary btn-small js-add-ticket" data-ticket="enfant">+</button>
                    <button class="btn btn-ghost btn-small js-remove-ticket" data-ticket="enfant">–</button>
                </div>
                <p class="ticket-qty-text">
                    Dans le panier : <span class="js-ticket-qty" data-ticket="enfant">0</span>
                </p>
            </article>

            {{-- VIP --}}
            <article class="ticket-card ticket-vip reveal tilt">
                <div class="ticket-tag">Expérience complète</div>
                <h3>Table VIP (x5)</h3>
                <p class="ticket-price">500 €</p>
                <p class="ticket-text">Repas complet + service + emplacement premium.</p>
                <div class="ticket-actions">
                    <button class="btn btn-primary btn-small js-add-ticket" data-ticket="vip">+</button>
                    <button class="btn btn-ghost btn-small js-remove-ticket" data-ticket="vip">–</button>
                </div>
                <p class="ticket-qty-text">
                    Dans le panier : <span class="js-ticket-qty" data-ticket="vip">0</span>
                </p>
            </article>

        </div>

        {{-- SHARE --}}
        <div class="share-bar reveal">
            <div class="share-text">Partage la soirée avec tes proches 🔥</div>
            <button class="btn btn-ghost btn-small" id="shareButton">Partager</button>
        </div>
        <br>

        {{-- PANIER --}}
        <div id="ticketCart" class="ticket-cart reveal">
            <div class="ticket-cart__left">
                <p class="ticket-cart__label">Panier</p>
                <p class="ticket-cart__info">
                    <span class="js-cart-count">0 billet</span>
                    <span class="ticket-cart__dot">•</span>
                    <span class="js-cart-total">0 €</span>
                </p>
                <p class="ticket-cart__hint">
                    Rentre ton email pour recevoir tes billets par mail.
                </p>
            </div>

            <form method="POST"
                  action="{{ route('tickets.checkout') }}"
                  class="ticket-cart__form">
                @csrf
                <div class="ticket-cart__names">
                    <div class="input-group">
                        <label>Prénom</label>
                        <input type="text" name="first_name" required placeholder="Ton prénom">
                    </div>

                    <div class="input-group">
                        <label>Nom</label>
                        <input type="text" name="last_name" required placeholder="Ton nom">
                    </div>
                </div>

                <input type="email"
                       name="email"
                       placeholder="Ton email"
                       required
                       class="ticket-cart__email">

                <input type="hidden" name="cart" class="js-cart-input">

                <button type="submit" class="btn btn-primary btn-small">
                    Payer en ligne
                </button>
            </form>
        </div>

    </div>
</section>

{{-- SECTION SPONSORS --}}
<section id="sponsors" class="section section-sponsors">
    <div class="section-inner">

        <header class="section-head reveal">
            <h2 class="section-title">Partenaires & soutiens</h2>
            <p class="section-intro">
                Le gala est rendu possible grâce au soutien de nos partenaires.
            </p>
        </header>

        <div class="sponsors-grid">

            <article class="sponsor-card reveal tilt">
                <div class="sponsor-logo"><img src="{{ asset('assets/img/partners/creditmutuel.png') }}" alt=""></div>
                <h3>Crédit Mutuel</h3><p>Partenaire financier du gala.</p>
            </article>

            <article class="sponsor-card reveal tilt">
                <div class="sponsor-logo"><img src="{{ asset('assets/img/partners/region.png') }}" alt=""></div>
                <h3>Région Auvergne Rhône-Alpes</h3><p>Soutien institutionnel.</p>
            </article>

            <article class="sponsor-card reveal tilt">
                <div class="sponsor-logo"><img src="{{ asset('assets/img/partners/ffboxe.jpg') }}" alt=""></div>
                <h3>FF Boxe</h3><p>Cadre officiel et fédéral.</p>
            </article>

            <article class="sponsor-card reveal tilt">
                <div class="sponsor-logo"><img src="{{ asset('assets/img/partners/rd.png') }}" alt=""></div>
                <h3>RD Boxing</h3><p>Équipementier du gala.</p>
            </article>

        </div>

    </div>
</section>

<script src="{{ asset('assets/js/sous-haute-tension.js') }}?v=3" defer></script>
</body>
</html>
