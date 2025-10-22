<header class="hdr-min" role="banner">
    {{-- Bouton ouverture modale (menu) --}}
    <button class="hdr-menu-open" type="button"
            data-hdr-menu-open aria-haspopup="dialog" aria-controls="hdrMenu">
        <span></span><span></span><span></span>
    </button>

    {{-- Action gauche : S’inscrire --}}
    <div class="left-actions">
        <a href="{{ route('enroll.step1') }}" class="btn ghost">S’inscrire</a>
    </div>

    {{-- Logo centré, rond --}}
    <a href="{{ route('home') }}" class="brand-center" aria-label="Accueil">
        <img src="{{ asset('assets/img/logo-team-bafounta.png') }}" alt="Team Bafounta" />
    </a>

    {{-- Actions droites : Contact + CTA S’inscrire --}}
    <div class="right-actions">
        <a href="{{ route('contact') }}" class="top-link">Contact</a>
        <a href="{{ route('enroll.step1') }}" class="btn cta">S’inscrire</a>
    </div>
</header>

{{-- === MENU MODALE CENTRÉ === --}}
<div class="hdr-menu-backdrop" data-hdr-menu-backdrop hidden></div>

<div id="hdrMenu" class="hdr-menu-modal"
     role="dialog" aria-modal="true" aria-labelledby="hdrMenuTitle"
     hidden data-hdr-menu>

    <button class="hdr-menu-close" type="button"
            aria-label="Fermer le menu" data-hdr-menu-close>✕</button>

    <div class="hdr-menu-grid">
        {{-- Colonne gauche : navigation --}}
        <div class="hdr-menu-left">
            <h2 id="hdrMenuTitle" class="hdr-menu-title">Navigation</h2>
            <ul class="hdr-menu-list" role="menu">
                <li role="none"><a role="menuitem" href="{{ route('enroll.step1') }}">Inscription</a></li>
                <li role="none"><a role="menuitem" href="{{ route('club') }}">Le Club</a></li>
                <li role="none"><a role="menuitem" href="{{ route('courses') }}">Cours & Horaires</a></li>
                <li role="none"><a role="menuitem" href="{{ route('pricing') }}">Tarifs</a></li>
                <li role="none"><a role="menuitem" href="{{ route('news.index') }}">Actualités</a></li>
                <li role="none"><a role="menuitem" href="{{ route('gallery') }}">Galerie</a></li>
                <li role="none"><a role="menuitem" href="{{ route('contact') }}">Contact</a></li>
                <li role="none"><a role="menuitem" href="{{ route('legal') }}">Mentions légales</a></li>
            </ul>

            <div class="hdr-menu-ctas">
                <a href="{{ route('enroll.step1') }}" class="hdr-cta-primary">S’inscrire</a>
                <a href="{{ route('contact') }}" class="hdr-cta-secondary">Contact</a>
            </div>

            <div class="hdr-menu-infos">
                <div class="row">
                    <a class="chip" href="tel:0636132175">06 36 13 21 75</a>
                    <a class="chip" href="mailto:espaceecolesportboxe@gmail.com">espaceecolesportboxe@gmail.com</a>
                </div>
                <div class="row">
                    <a class="ico" href="https://instagram.com" target="_blank" rel="noopener">IG</a>
                    <a class="ico" href="https://facebook.com"  target="_blank" rel="noopener">FB</a>
                </div>
            </div>
        </div>

        {{-- Colonne droite : visuel (image ou vidéo) --}}
        <div class="hdr-menu-right">
            <img src="{{ asset('assets/img/menu-visual.jpg') }}"
                 alt="Ring Team Bafounta" class="hdr-menu-visual">
            {{--
            <video class="hdr-menu-visual" autoplay muted loop playsinline>
              <source src="{{ asset('assets/video/menu.mp4') }}" type="video/mp4">
            </video>
            --}}
        </div>
    </div>
</div>
