<header class="hdr-min" role="banner">
    {{-- Bouton burger --}}
    <button
        class="hdr-menu-open"
        type="button"
        data-hdr-menu-open
        aria-haspopup="dialog"
        aria-controls="hdrMenu"
        aria-expanded="false"
        aria-label="Ouvrir le menu"
    >
        <span></span><span></span><span></span>
    </button>

    {{-- CSS du header --}}
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}?v=10">

    {{-- Logo centré --}}
    <a href="{{ route('home') }}" class="brand-center" aria-label="Accueil Team Bafounta">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Team Bafounta" />
    </a>

    {{-- Actions à droite (switch + liens) --}}
    <div class="right-actions">
        <a href="{{ route('contact') }}" class="top-link">Contact</a>
        <a href="{{ route('enroll.step1') }}" class="btn cta">S’inscrire</a>
    </div>
</header>

{{-- Backdrop modal --}}
<div class="hdr-menu-backdrop" data-hdr-menu-backdrop hidden></div>

{{-- MENU MODAL --}}
<div
    id="hdrMenu"
    class="hdr-menu-modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="hdrMenuTitle"
    hidden
    data-hdr-menu
    tabindex="-1"
>
    <button class="hdr-menu-close" type="button" aria-label="Fermer le menu" data-hdr-menu-close>✕</button>
    <div class="hdr-menu-grid">
        {{-- Colonne gauche : titre + liens + CTA + infos --}}
        <div class="hdr-menu-left">
            <h2 id="hdrMenuTitle" class="hdr-menu-title">Team Bafounta</h2>
            @php
                $nbsp = "\u{00A0}";
                $fmt  = static fn(string $s) => str_replace(' & ', $nbsp.'&'.$nbsp, $s);
                $links = [
                    ['route' => 'club',       'label' => $fmt('Le Club'),          'match' => ['club']],
                    ['route' => 'courses',    'label' => $fmt('Cours & Horaires'), 'match' => ['courses']],
                    ['route' => 'pricing',    'label' => $fmt('Tarifs'),           'match' => ['pricing']],
                    ['route' => 'news.index', 'label' => $fmt('Actualités'),       'match' => ['news.*']],
                    ['route' => 'boutique',    'label' => $fmt('Boutique'),          'match' => ['gallery']],
                ];
            @endphp
            <ul class="menu" role="menu">
                @foreach($links as $l)
                    @php $active = request()->routeIs($l['match']); @endphp
                    <li class="menu__item {{ $active ? 'is-active' : '' }}" role="none">
                        <a class="menu__link" role="menuitem" href="{{ route($l['route']) }}">
                            <span class="menu__label">{{ $l['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="hdr-side-actions">
                {{-- CTA principal --}}
                <a href="{{ route('enroll.step1') }}" class="hdr-side-cta">
                    Rejoindre la Team
                </a>

                {{-- Contact --}}
                <div class="hdr-side-contact">
                    <a class="hdr-side-pill" href="tel:0636132175">
                        <span class="hdr-side-pill__ico">📞</span>
                        <span class="hdr-side-pill__txt">06 36 13 21 75</span>
                    </a>

                    <a class="hdr-side-pill" href="mailto:espaceecolesportboxe@gmail.com">
                        <span class="hdr-side-pill__ico">✉️</span>
                        <span class="hdr-side-pill__txt">espaceecolesportboxe@gmail.com</span>
                    </a>
                </div>

                {{-- Réseaux --}}
                <div class="hdr-side-social">
                    <a class="hdr-side-icon" href="https://www.instagram.com/teambafounta/" target="_blank" rel="noopener"
                       aria-label="Instagram" title="Instagram">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 2C4.2 2 2 4.2 2 7v10c0 2.8 2.2 5 5 5h10c2.8 0 5-2.2 5-5V7c0-2.8-2.2-5-5-5H7Zm10 2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3H7a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3h10Zm-5 3.5A4.5 4.5 0 1 0 16.5 12 4.5 4.5 0 0 0 12 7.5Zm0 7.3A2.8 2.8 0 1 1 14.8 12 2.8 2.8 0 0 1 12 14.8Zm4.9-8.9a1 1 0 1 0 1 1 1 1 0 0 0-1-1Z"/></svg>
                    </a>

                    <a class="hdr-side-icon ico--fb" href="https://facebook.com" target="_blank" rel="noopener"
                       aria-label="Facebook" title="Facebook">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 2H10a5 5 0 0 0-5 5v3H3v4h2v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3.5V2Z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Colonne droite : visuel pleine hauteur --}}
        <div class="hdr-menu-right">
            <img src="{{ asset('assets/img/menu2.jpg') }}" alt="">
            <img src="{{ asset('assets/img/menu1.png') }}" alt="">
            <img src="{{ asset('assets/img/jeremyboxe.jpg') }}" alt="">
        </div>
    </div>
</div>

{{-- JS du menu (ouvertures/fermetures, lock scroll, focus trap) --}}
<script src="{{ asset('assets/js/header-menu.js') }}?v=3" defer></script>

