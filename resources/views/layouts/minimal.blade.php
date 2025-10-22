<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Team Bafounta' }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    @yield('styles')
</head>
<body>
<main id="main" class="container">
    @yield('content')
</main>
@yield('scripts')
</body>
</html>
