<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Team Bafounta' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/boutique.css') }}">
    <script src="{{ asset('assets/js/header.js') }}" defer></script>


    @yield('styles')

    <!-- No-FOUC theme bootstrap -->
    <script>
        (function () {
            try {
                const saved = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const initial = saved || (prefersDark ? 'dark' : 'light');
                document.documentElement.setAttribute('data-theme', initial);
            } catch(e){}
        })();
    </script>

</head>
<body>
@include('partials.header')

<main id="main" class="container">
    @yield('content')
</main>

@include('partials.footer')

@yield('scripts')

<script src="{{ asset('assets/js/theme.js') }}" defer></script>

</body>
</html>
