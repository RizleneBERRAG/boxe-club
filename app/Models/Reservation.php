<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'product_id',
        'first_name',
        'last_name',
        'phone',
        'size',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
