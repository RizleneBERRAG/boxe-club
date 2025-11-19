@extends('layouts.app')

@section('content')
    <div class="admin-page">
        <div class="admin-header">
            <h1>Tableau de bord</h1>
            <p>Gestion globale du club : boutique, inscriptions, paiements…</p>
        </div>

        <div class="admin-cards">
            <div class="admin-card-small">
                <h2>Produits boutique</h2>
                <p class="admin-card-number">{{ $productsCount }}</p>
                <a href="{{ route('admin.products.index') }}" class="admin-card-link">Voir les produits</a>
            </div>

            @if(!is_null($enrollmentsCount))
                <div class="admin-card-small">
                    <h2>Dossiers d’inscription</h2>
                    <p class="admin-card-number">{{ $enrollmentsCount }}</p>
                    {{-- lien futur vers la gestion des dossiers --}}
                </div>
            @endif

            @if(!is_null($paymentsCount))
                <div class="admin-card-small">
                    <h2>Paiements</h2>
                    <p class="admin-card-number">{{ $paymentsCount }}</p>
                    {{-- lien futur vers la gestion des paiements --}}
                </div>
            @endif
        </div>
    </div>
@endsection
