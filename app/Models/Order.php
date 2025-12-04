<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Order extends Model
{
    // IMPORTANT : autoriser tous les champs à être remplis via create()
    protected $guarded = [];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function generatedTickets(): HasManyThrough
    {
        return $this->hasManyThrough(GeneratedTicket::class, OrderItem::class);
    }
}
