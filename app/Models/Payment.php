<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'enrollment_id',
        'amount_cents',
        'method',           // enum: card|cash|wire
        'status',           // enum: pending|paid
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }
}
