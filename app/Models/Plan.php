<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $fillable = [
        'name', 'price_cents', 'description', 'allow_split', 'is_active',
    ];

    protected $casts = [
        'allow_split' => 'bool',
        'is_active'   => 'bool',
    ];

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    // Helper pratique
    public function getPriceFormattedAttribute(): string
    {
        return number_format($this->price_cents / 100, 2, ',', ' ') . ' €';
    }
}
