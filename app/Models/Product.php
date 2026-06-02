<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;   // ← IMPORTANT : c’est ça qu’il manquait

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',      // <— ajouter
        'slug',
        'price_cents',
        'description',
        'image_path',
        'sizes',
        'is_active',
    ];

    protected $casts = [
        'sizes' => 'array',
        'is_active' => 'bool',
        'price'     => 'float',

    ];

    public static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);   // maintenant ça fonctionne
        $slug     = $baseSlug;
        $i        = 2;

        while (
        static::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }

        return $slug;
    }
}
