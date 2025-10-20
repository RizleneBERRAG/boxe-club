<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Team Bafounta' }}</title>

    @php
        if (!function_exists('assetV')) {
            function assetV($path) {
                $full = public_path($path);
                return asset($path) . (file_exists($full) ? ('?v=' . filemtime($full)) : '');
            }
        }
    @endphp>

    {{-- CSS global + CSS page (optionnel via @section styles) --}}
    <link rel="stylesheet" href="{{ assetV('assets/css/global.css') }}">
    @yield('styles')
</head>
<body>
<a href="#main" class="sr-only">Aller au contenu</a>

{{-- ================== HEADER (inline) ================== --}}
<header class="hdr" role="banner">
    <!-- Topbar compacte -->
    <div class="hdr-top">
        <div class="wrap">
            <div class="chips">
                <span class="chip">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5z"/></svg>
                    Jacques Brel — 7 Av. d’Oschatz
                </span>
                <span class="dot"></span>
                <span class="chip">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5z"/></svg>
                    Jean Guimier — Av. Jules Guesde
                </span>
            </div>

            <div class="actions">
                <a class="chip" href="tel:0636132175">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.62 10.79a15.91 15.91 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.01-.24 12.36 12.36 0 0 0 3.88.62 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 7a1 1 0 0 1 1-1h2.44a1 1 0 0 1 1 1 12.36 12.36 0 0 0 .62 3.88 1 1 0 0 1-.24 1.01Z"/></svg>
                    06 36 13 21 75
                </a>
                <a class="chip" href="mailto:espaceecolesportboxe@gmail.com">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 4H4a2 2 0 0 0-2 2v1.2l10 5.8 10-5.8V6a2 2 0 0 0-2-2Zm2 6.25-9.4 5.46a1.5 1.5 0 0 1-1.2 0L2 10.25V18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2Z"/></svg>
                    espaceecolesportboxe@gmail.com
                </a>

                <nav class="social" aria-label="Réseaux sociaux">
                    <a class="ico" href="https://www.instagram.com/" target="_blank" rel="noopener" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Zm5 5.5A5.5 5.5 0 1 1 6.5 13 5.5 5.5 0 0 1 12 7.5Z"/></svg>
                    </a>
                    <a class="ico" href="https://www.facebook.com/" target="_blank" rel="noopener" aria-label="Facebook">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 9H16l.5-3h-3V4.5A1.5 1.5 0 0 1 15 3h1.5V0H14a4 4 0 0 0-4 4v2H8v3h2v9h3z"/></svg>
                    </a>
                </nav>
            </div>
        </div>
    </div>

    <!-- Main bar -->
    <div class="hdr-main">
        <div class="wrap">
            <a href="{{ route('home') }}" class="brand" aria-label="Accueil Team Bafounta">
                <span class="logo">TB</span>
                <span class="txt">Team <strong>Bafounta</strong></span>
            </a>

            <button class="burger" aria-expanded="false" aria-controls="site-nav" aria-label="Ouvrir le menu">
                <span></span><span></span><span></span>
            </button>

            <nav id="site-nav" class="nav" data-nav>
                <ul class="menu">
                    <li><a class="lnk {{ request()->routeIs('enroll.*')? 'is-active':'' }}" href="{{ route('enroll.step1') }}">Inscription</a></li>
                    <li><a class="lnk {{ request()->routeIs('club')? 'is-active':'' }}" href="{{ route('club') }}">Le Club</a></li>
                    <li><a class="lnk {{ request()->routeIs('courses')? 'is-active':'' }}" href="{{ route('courses') }}">Cours & Horaires</a></li>
                    <li><a class="lnk {{ request()->routeIs('pricing')? 'is-active':'' }}" href="{{ route('pricing') }}">Tarifs</a></li>
                    <li><a class="lnk {{ request()->routeIs('news.*')? 'is-active':'' }}" href="{{ route('news.index') }}">Actualités</a></li>
                    <li><a class="lnk {{ request()->routeIs('gallery')? 'is-active':'' }}" href="{{ route('gallery') }}">Galerie</a></li>
                    <li><a class="lnk {{ request()->routeIs('contact')? 'is-active':'' }}" href="{{ route('contact') }}">Contact</a></li>
                </ul>
                <a class="cta" href="{{ route('enroll.step1') }}">Séance d’essai</a>
            </nav>
        </div>
    </div>
</header>
{{-- ================== /HEADER ================== --}}

<main id="main" class="container">
    @yield('content')
</main>

<footer class="site-footer">
    <div class="container">
        <p>© {{ date('Y') }} Team Bafounta — Tous droits réservés.</p>
        <p><a href="{{ route('legal') }}">Mentions légales & RGPD</a></p>
    </div>
</footer>

{{-- JS global + JS page --}}
<script src="{{ assetV('assets/js/global.js') }}" defer></script>
@yield('scripts')
</body>
</html>
