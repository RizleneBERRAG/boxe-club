<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active'   => 'required|boolean',
            'sizes'       => 'nullable|array',
            'category'    => 'required|string|max:255',
            'image'       => 'nullable|image|max:5120', // 5MB
        ]);

        // slug
        $data['slug']  = Product::generateUniqueSlug($data['name']);
        $data['sizes'] = $data['sizes'] ?? [];

        // Upload + optimisation
        if ($request->hasFile('image')) {
            $original = $request->file('image');

            $img = Image::make($original);

            // Max 1200px de large
            $img->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $filename = 'product-' . time() . '.jpg';

            $img->encode('jpg', 80);
            $img->save(storage_path('app/public/products/' . $filename));

            $data['image_path'] = 'products/' . $filename;
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produit créé avec optimisation d’image 👍');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|in:vetement,gants,bandes,chaussures,protege_dents,autre',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:5120', // 5 Mo comme pour le store
            'is_active'   => 'nullable|boolean',
            'sizes'       => 'array',
            'sizes.*'     => 'string|max:20',
        ]);

        // Toujours avoir un tableau pour sizes
        $sizes = $data['sizes'] ?? [];

        // Upload / remplacement d'image (optionnel)
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image_path = $path;
        }

        // Assigner explicitement tous les champs
        $product->name        = $data['name'];
        $product->category    = $data['category'];
        $product->price       = $data['price'];          // <= ICI le prix est bien mis à jour
        $product->description = $data['description'] ?? null;
        $product->sizes       = $sizes;
        $product->is_active   = $request->boolean('is_active', true);

        // Slug unique en fonction du nom
        $product->slug = Product::generateUniqueSlug($data['name'], $product->id);

        $product->save();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produit mis à jour.');
    }

    public function destroy(Product $product)
    {
        // (optionnel) supprime aussi l’image
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produit supprimé.');
    }
}
