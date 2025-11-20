<header class="admin-header">
    <div class="left">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <img src="{{ asset('assets/img/logo.png') }}" alt="logo">
        </a>
        <span class="title">Espace Admin</span>
    </div>

    <div class="right">
        <a href="{{ route('admin.products.index') }}">Produits</a>

        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Déconnexion</button>
        </form>
    </div>
</header>
