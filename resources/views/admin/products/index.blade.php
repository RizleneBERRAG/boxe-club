@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto py-10">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-white">Boutique – Produits</h1>

            <a href="{{ route('admin.products.create') }}"
               class="px-5 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold shadow-lg">
                Ajouter un produit
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-600/20 border border-green-500 px-4 py-3 text-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if($products->isEmpty())
            <div class="rounded-2xl bg-zinc-900/80 px-6 py-6 text-zinc-300 shadow-inner">
                Aucun produit pour le moment.
            </div>
        @else
            <div class="rounded-2xl bg-zinc-900/80 shadow-lg overflow-hidden">
                <table class="w-full text-left text-sm text-zinc-200">
                    <thead class="bg-zinc-950/70 text-xs uppercase text-zinc-400">
                    <tr>
                        <th class="px-6 py-4">Produit</th>
                        <th class="px-6 py-4">Prix</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr class="border-t border-zinc-800 hover:bg-zinc-900/70">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($product->image_path)
                                        <img src="{{ asset('storage/'.$product->image_path) }}"
                                             class="w-12 h-12 rounded-lg object-cover">
                                    @endif
                                    <div>
                                        <div class="font-semibold">{{ $product->name }}</div>
                                        <div class="text-xs text-zinc-400 line-clamp-1">
                                            {{ $product->description }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                {{ number_format($product->price, 2, ',', ' ') }} €
                            </td>
                            <td class="px-6 py-4">
                                @if($product->is_active)
                                    <span class="px-2 py-1 rounded-full bg-green-600/20 text-green-300 text-xs">
                                        Visible
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded-full bg-zinc-700 text-zinc-200 text-xs">
                                        Caché
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="px-3 py-1 text-xs rounded-lg bg-zinc-800 hover:bg-zinc-700">
                                        Modifier
                                    </a>

                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                          onsubmit="return confirm('Supprimer ce produit ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 text-xs rounded-lg bg-red-700 hover:bg-red-800 text-white">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
