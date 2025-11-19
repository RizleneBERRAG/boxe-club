<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        // Ici seulement les produits "visibles"
        $products = Product::where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.boutique', compact('products'));
    }


    public function reserve(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'phone'      => 'required|string|max:30',
            'size'       => 'required|string|max:10',
        ]);

        Reservation::create($data);

        return back()->with('success', 'Réservation enregistrée ! Vous pourrez récupérer et régler votre article directement au club.');
    }
}
