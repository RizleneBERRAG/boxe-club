@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/boutique.css') }}?v=3">
@endsection

@section('content')
    <div class="shop-page">

        <div class="shop-hero">
            <div class="shop-hero-main">
                <div class="shop-eyebrow">Team Bafounta • Boutique</div>
                <h1 class="shop-title">Équipe-toi comme un champion</h1>
                <p class="shop-subtitle">
                    Survêtements, maillots et tenues officielles du club. Réserve ton article,
                    viens l’essayer et régler directement à la salle.
                </p>
            </div>

            <div class="shop-hero-badge">
                <div class="shop-badge-icon">🥊</div>
                <div class="shop-badge-text">
                    <span>Retrait au club</span><br>
                    <span>Parc de Parilly • Vénissieux</span>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="shop-success">
                {{ session('success') }}
            </div>
        @endif

        @if($products->isEmpty())
            <p class="shop-empty">Aucun produit disponible pour le moment.</p>
        @else
            <div class="shop-grid">
                @foreach($products as $product)
                    <article class="product-card">
                        <div class="product-image-wrapper">
                            @if($product->image_path)
                                <img src="{{ asset('storage/'.$product->image_path) }}"
                                     alt="{{ $product->name }}"
                                     class="product-image">
                            @else
                                <div class="product-image product-image-placeholder">
                                    Image à venir
                                </div>
                            @endif

                            @if(is_array($product->sizes) && count($product->sizes))
                                <div class="product-tags">
                                    @foreach($product->sizes as $size)
                                        <span class="product-tag">{{ $size }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="product-body">
                            <div class="product-header">
                                <h2 class="product-name">{{ $product->name }}</h2>
                                <p class="product-description">{{ $product->description }}</p>
                            </div>

                            <div class="product-footer">
                                <div class="product-price">
                                    {{ number_format($product->price, 2, ',', ' ') }} €
                                </div>
                                <button type="button"
                                        class="btn btn-primary"
                                        onclick="openReservationModal({{ $product->id }}, '{{ addslashes($product->name) }}', {!! json_encode($product->sizes ?? []) !!})">
                                    Réserver
                                </button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>

    {{-- MODAL RÉSERVATION --}}
    <div id="reservation-backdrop" class="shop-modal-backdrop is-hidden">
        <div class="shop-modal">
            <button type="button" class="shop-modal-close" onclick="closeReservationModal()">×</button>

            <h2 class="shop-modal-title">Réservation</h2>
            <p class="shop-modal-intro">
                Tu réserves l’article :
                <span id="modal-product-name" class="shop-modal-product"></span><br>
                <span class="shop-modal-note">Règlement et retrait directement au club.</span>
            </p>

            <form action="{{ route('reservation.submit') }}" method="POST" class="shop-modal-form">
                @csrf
                <input type="hidden" name="product_id" id="modal-product-id">

                <div class="shop-modal-row">
                    <div class="shop-modal-field">
                        <label>Nom *</label>
                        <input type="text" name="last_name" required>
                    </div>

                    <div class="shop-modal-field">
                        <label>Prénom *</label>
                        <input type="text" name="first_name" required>
                    </div>
                </div>

                <div class="shop-modal-field">
                    <label>Téléphone *</label>
                    <input type="text" name="phone" required>
                    <small>Utilisé uniquement pour confirmer ta réservation.</small>
                </div>

                <div class="shop-modal-field">
                    <label>Taille *</label>
                    <select name="size" id="modal-sizes" required></select>
                </div>

                <div class="shop-modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeReservationModal()">Annuler</button>
                    <button type="submit" class="btn btn-primary">Confirmer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openReservationModal(id, name, sizes) {
            document.getElementById('modal-product-id').value = id;
            document.getElementById('modal-product-name').textContent = name;

            const select = document.getElementById('modal-sizes');
            select.innerHTML = '';

            if (sizes && sizes.length) {
                sizes.forEach(size => {
                    let opt = document.createElement('option');
                    opt.value = size;
                    opt.textContent = size;
                    select.appendChild(opt);
                });
            }

            document.getElementById('reservation-backdrop').classList.remove('is-hidden');
        }

        function closeReservationModal() {
            document.getElementById('reservation-backdrop').classList.add('is-hidden');
        }
    </script>
@endsection
