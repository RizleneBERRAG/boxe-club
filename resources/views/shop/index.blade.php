@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-10">
        <h1 class="text-4xl font-extrabold text-white mb-8">Boutique</h1>

        @if($products->isEmpty())
            <p class="text-zinc-300">La boutique arrive bientôt, aucun produit pour le moment.</p>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($products as $product)
                    <div class="rounded-2xl bg-zinc-900/80 shadow-lg overflow-hidden flex flex-col">
                        @if($product->image_path)
                            <img src="{{ asset('storage/'.$product->image_path) }}"
                                 class="h-48 w-full object-cover">
                        @endif

                        <div class="p-5 flex flex-col flex-1">
                            <h2 class="text-xl font-semibold text-white mb-2">
                                {{ $product->name }}
                            </h2>
                            <p class="text-sm text-zinc-400 mb-4 flex-1">
                                {{ $product->description }}
                            </p>

                            <div class="flex items-center justify-between mt-auto">
                                <div class="text-lg font-bold text-red-500">
                                    {{ number_format($product->price, 2, ',', ' ') }} €
                                </div>
                                <button class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm">
                                    Ajouter au panier
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
