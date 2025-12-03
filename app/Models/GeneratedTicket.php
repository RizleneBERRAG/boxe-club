<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedTicket extends Model
{
    protected $fillable = [
        'order_item_id',
        'uuid',
        'qr_code_path',
        'status',
        'scanned_at',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    // accès rapide au type de billet via l’order_item
    public function ticketType()
    {
        return $this->hasOneThrough(
            TicketType::class,
            OrderItem::class,
            'id',              // clé locale sur order_items
            'id',              // clé locale sur ticket_types
            'order_item_id',   // colonne sur generated_tickets
            'ticket_type_id'   // colonne sur order_items
        );
    }
}
