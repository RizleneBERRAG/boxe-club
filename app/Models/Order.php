<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'email',
        'total_cents',
        'stripe_session_id',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // tous les generated_tickets liés via les items
    public function generatedTickets()
    {
        return $this->hasManyThrough(
            GeneratedTicket::class,
            OrderItem::class
        );
    }
}
