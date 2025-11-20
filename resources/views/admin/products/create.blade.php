@extends('layouts.admin')

@section('title', 'Ajouter un produit')

@section('content')
    <div class="admin-page">

        <a href="{{ route('admin.products.index') }}" class="admin-back-link">
            ← Retour à la liste des produits
        </a>

        <h1 class="admin-page-title">Ajouter un produit</h1>
        <p class="admin-page-intro">
            Crée un nouvel article pour la boutique Team Bafounta.
        </p>

        {{-- Affichage des erreurs --}}
        @include('admin.partials.errors')

        {{-- Formulaire réutilisable (create / edit) --}}
        @include('admin.products._form', [
            'method'  => 'POST',
            'action'  => route('admin.products.store'),
            'product' => null,
            'button'  => 'Ajouter le produit',
        ])
    </div>
@endsection
