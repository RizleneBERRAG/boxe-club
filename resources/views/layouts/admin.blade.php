<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Admin – Team Bafounta' }}</title>

    {{-- CSS global --}}
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    @yield('styles')
</head>

<body class="admin-body">

<header class="admin-topbar">
    <div class="admin-topbar-left">
        <a href="{{ route('home') }}" class="admin-topbar-logo">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Team Bafounta">
        </a>
        <span class="admin-topbar-title">Espace Admin</span>
    </div>

    @auth
        <div class="admin-topbar-right">
            <a href="{{ route('admin.products.index') }}" class="admin-topbar-link">
                Produits
            </a>

            <form action="{{ route('admin.logout') }}" method="POST" class="admin-topbar-logout">
                @csrf
                <button type="submit">Déconnexion</button>
            </form>
        </div>
    @endauth
</header>

<main class="admin-main">
    @yield('content')
</main>

</body>
</html>
