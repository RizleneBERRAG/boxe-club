@extends('layouts.admin')

@section('title', 'Boutique – Produits')

@section('content')
    <div class="admin-page">

        <a href="{{ route('admin.dashboard') }}" class="admin-back-link">
            ← Retour au tableau de bord
        </a>

        <div class="admin-page-header">
            <h1 class="admin-page-title"> Liste des produits </h1>

            <a href="{{ route('admin.products.create') }}" class="btn-primary">
                + Ajouter un produit
            </a>
        </div>

        <p class="admin-page-intro">
            Gère ici les articles visibles sur la boutique publique.
        </p>

        @if($products->isEmpty())
            <p class="admin-empty">Aucun produit pour le moment.</p>
        @else
            <div class="admin-products-table">

                <div class="admin-products-head">
                    <div>Visuel</div>
                    <div>Produit</div>
                    <div>Prix</div>
                    <div>Tailles</div>
                    <div>Statut</div>
                    <div>Actions</div>
                </div>

                @foreach($products as $product)
                    <div class="admin-products-row">
                        {{-- Visuel --}}
                        <div class="admin-products-thumb">
                            @if($product->image_path)
                                <img src="{{ asset('storage/'.$product->image_path) }}"
                                     alt="{{ $product->name }}">
                            @else
                                <div class="admin-thumb-placeholder">Aucune image</div>
                            @endif
                        </div>

                        {{-- Nom + description courte --}}
                        <div class="admin-products-info">
                            <div class="admin-product-name">{{ $product->name }}</div>
                            @if($product->description)
                                <div class="admin-product-desc">
                                    {{ \Illuminate\Support\Str::limit($product->description, 70) }}
                                </div>
                            @endif
                        </div>

                        {{-- Prix --}}
                        <div class="admin-products-price">
                            {{ number_format($product->price, 2, ',', ' ') }} €
                        </div>

                        {{-- Tailles --}}
                        <div class="admin-products-sizes">
                            @if(is_array($product->sizes) && count($product->sizes))
                                @foreach($product->sizes as $size)
                                    <span class="chip">{{ $size }}</span>
                                @endforeach
                            @else
                                —
                            @endif
                        </div>

                        {{-- Statut --}}
                        <div class="admin-products-status">
                            <span class="status-pill {{ $product->is_active ? 'is-active' : 'is-inactive' }}">
                                {{ $product->is_active ? 'Visible' : 'Caché' }}
                            </span>
                        </div>

                        {{-- Actions --}}
                        <div class="admin-products-actions">
                            <a href="{{ route('admin.products.edit', $product) }}" class="link-muted">
                                Modifier
                            </a>

                            <form action="{{ route('admin.products.destroy', $product) }}"
                                  method="POST"
                                  onsubmit="return confirm('Supprimer ce produit ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="link-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif
    </div>
@endsection
