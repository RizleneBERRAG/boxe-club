<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Espace Admin — Team Bafounta' }}</title>

    {{-- CSS global --}}
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">

    {{-- CSS Admin uniquement --}}
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">

    @yield('styles')
</head>

<body class="admin-login-body">
<main class="admin-login-container">
    @yield('content')
</main>

@yield('scripts')
</body>
</html>
