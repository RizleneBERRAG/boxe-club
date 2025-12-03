<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketType extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'label',
        'price_cents',
        'max_per_order',
        'stock',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function generatedTickets()
    {
        return $this->hasMany(GeneratedTicket::class);
    }
}
