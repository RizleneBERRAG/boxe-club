@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto py-12 px-4">

        <h1 class="text-3xl font-bold text-white mb-8">Modifier un produit</h1>

        <form action="{{ route('admin.products.update', $product->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-8 bg-zinc-900/60 rounded-2xl p-8 border border-zinc-800 shadow-xl">

            @csrf
            @method('PUT')

            {{-- Nom --}}
            <div>
                <label class="block text-sm text-zinc-300 font-medium mb-1">Nom du produit *</label>
                <input type="text" name="name" value="{{ $product->name }}" required
                       class="w-full p-3 bg-zinc-800 border border-zinc-700 rounded-xl text-white focus:ring-2 focus:ring-red-600">
            </div>

            {{-- Prix --}}
            <div>
                <label class="block text-sm text-zinc-300 font-medium mb-1">Prix (€) *</label>
                <input type="number" name="price" step="0.01" required value="{{ $product->price }}"
                       class="w-full p-3 bg-zinc-800 border border-zinc-700 rounded-xl text-white focus:ring-2 focus:ring-red-600">
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm text-zinc-300 font-medium mb-1">Description</label>
                <textarea name="description" rows="4"
                          class="w-full p-3 bg-zinc-800 border border-zinc-700 rounded-xl text-white">{{ $product->description }}</textarea>
            </div>

            {{-- Image --}}
            <div>
                <label class="block text-sm text-zinc-300 font-medium mb-1">Image du produit</label>
                <input type="file" name="image"
                       class="w-full p-3 bg-zinc-800 border border-zinc-700 rounded-xl text-white">

                @if($product->image_path)
                    <p class="text-xs text-zinc-500 mt-2">Image actuelle :</p>
                    <img src="{{ asset('storage/'.$product->image_path) }}"
                         class="w-32 h-32 object-cover rounded-lg mt-1">
                @endif
            </div>

            {{-- Tailles --}}
            <div>
                @php
                    $allSizes = ['XS','S','M','L','XL','XXL'];
                    $selected = $product->sizes ?? [];
                @endphp

                <label class="block text-sm text-zinc-300 font-medium">Tailles disponibles</label>
                <div class="flex flex-wrap gap-3 mt-2">
                    @foreach($allSizes as $size)
                        <label class="flex items-center gap-2 px-3 py-1 bg-zinc-800 rounded-lg border border-zinc-700 text-white text-sm">
                            <input type="checkbox" name="sizes[]" value="{{ $size }}"
                                {{ in_array($size, $selected) ? 'checked' : '' }}>
                            {{ $size }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Statut --}}
            <div>
                <label class="block text-sm text-zinc-300 font-medium mb-1">Statut</label>
                <select name="is_active" class="w-full p-3 bg-zinc-800 border border-zinc-700 rounded-xl text-white">
                    <option value="1" {{ $product->is_active ? 'selected' : '' }}>Visible</option>
                    <option value="0" {{ !$product->is_active ? 'selected' : '' }}>Caché</option>
                </select>
            </div>

            {{-- Bouton --}}
            <div class="pt-4">
                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl text-lg font-semibold shadow-lg">
                    Enregistrer les modifications
                </button>
            </div>

        </form>

    </div>
@endsection
