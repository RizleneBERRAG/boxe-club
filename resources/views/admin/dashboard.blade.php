@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
    <div class="admin-page">

        {{-- Top bar / header interne --}}
        <div class="admin-dashboard-header">
            <h1 class="admin-page-title">Tableau de bord</h1>

            <div class="admin-dashboard-actions">
                <a href="{{ url('/') }}" target="_blank" class="btn-ghost">
                    Aller sur le site →
                </a>

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button class="btn-primary">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>

        <p class="admin-page-intro">
            Gestion globale du club : boutique, inscriptions, paiements…
        </p>

        <div class="admin-dashboard-grid">

            {{-- Produits boutique --}}
            <div class="admin-dashboard-card">
                <strong>Produits boutique</strong>
                <div class="admin-dashboard-number">
                    {{ $productCount }}
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn-ghost">
                    Voir les produits →
                </a>
            </div>

            {{-- Inscriptions --}}
            <div class="admin-dashboard-card">
                <strong>Dossiers d'inscription</strong>
                <div class="admin-dashboard-number">
                    {{ $enrollmentCount }}
                </div>
                <span class="admin-dashboard-sub">Module en cours…</span>
            </div>

            {{-- Paiements --}}
            <div class="admin-dashboard-card">
                <strong>Paiements</strong>
                <div class="admin-dashboard-number">
                    {{ $paymentCount }}
                </div>
                <span class="admin-dashboard-sub">Module en cours…</span>
            </div>


        </div>

    </div>
@endsection
