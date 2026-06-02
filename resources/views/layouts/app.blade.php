<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Team Bafounta' }}</title>

    {{-- CSS globaux --}}
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/club.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/courses.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pricing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/boutique.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">

    @yield('styles')

    <script src="{{ asset('assets/js/header.js') }}" defer></script>

    {{-- thème dark/light sans FOUC --}}
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
{{-- Header : public ou admin selon l’URL --}}
@if (request()->is('admin*'))
    @include('partials.admin-header')
@else
    @include('partials.header')
@endif

<main id="main" class="container">
    @yield('content')
</main>

@include('partials.footer')

@yield('scripts')

<script src="{{ asset('assets/js/theme.js') }}" defer></script>
</body>
</html>
