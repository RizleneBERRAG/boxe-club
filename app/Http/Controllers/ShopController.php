<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.boutique', compact('products'));
    }

    public function reserve(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'last_name'  => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'phone'      => 'required|string|max:30',
            'size'       => 'required|string|max:10',
        ]);

        Reservation::create($data);

        return back()->with('success', 'Ta réservation est bien enregistrée.');
    }
}
