<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'product_id',
        'last_name',
        'first_name',
        'phone',
        'size',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
