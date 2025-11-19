@extends('layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}?v=3">
@endsection
@section('content')
    <div class="admin-page">

        <div class="admin-header">
            <h1>Ajouter un produit</h1>
            <p>Crée un nouvel article pour la boutique Team Bafounta.</p>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="admin-card">
            @csrf

            <div class="admin-grid-2">
                <div class="admin-field">
                    <label>Nom du produit *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="admin-field">
                    <label>Prix (€) *</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" required>
                </div>
            </div>

            <div class="admin-field">
                <label>Description</label>
                <textarea name="description" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="admin-field">
                <label>Image du produit</label>
                <input type="file" name="image">
                <small>Format JPG / PNG — 5MB max.</small>
            </div>

            <div class="admin-field">
                <label>Tailles disponibles</label>
                <div class="admin-sizes">
                    @php
                        $allSizes = ['XS','S','M','L','XL','XXL'];
                        $oldSizes = old('sizes', []);
                    @endphp

                    @foreach($allSizes as $size)
                        <label class="admin-size-pill">
                            <input type="checkbox" name="sizes[]" value="{{ $size }}" {{ in_array($size, $oldSizes) ? 'checked' : '' }}>
                            <span>{{ $size }}</span>
                        </label>
                    @endforeach
                </div>
                <small>Sélectionne les tailles réellement disponibles.</small>
            </div>

            <div class="admin-field">
                <label>Statut</label>
                <select name="is_active">
                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Visible</option>
                    <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>Caché</option>
                </select>
            </div>

            <div class="admin-actions">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Ajouter le produit</button>
            </div>
        </form>
    </div>
@endsection
