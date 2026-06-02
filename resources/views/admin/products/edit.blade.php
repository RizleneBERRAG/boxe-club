@extends('layouts.admin')

@section('title', 'Modifier un produit')

@section('content')
    <div class="admin-page">

        <a href="{{ route('admin.products.index') }}" class="admin-back-link">
            ← Retour à la liste des produits
        </a>

        <h1 class="admin-page-title">Modifier le produit</h1>
        <p class="admin-page-intro">
            Mets à jour les infos de cet article.
        </p>

        @include('admin.partials.errors')

        @include('admin.products._form', [
            'method'  => 'PUT',
            'action'  => route('admin.products.update', $product),
            'product' => $product,
            'button'  => 'Enregistrer les modifications',
        ])
    </div>
@endsection
