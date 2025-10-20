<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enrollment extends Model
{
    protected $fillable = [
        'dossier_ref',
        'first_name', 'last_name', 'email', 'phone',
        'birthdate', 'is_minor',
        'parent_name', 'parent_date',
        'plan_id',
        'rgpd',
        'status',          // enum: draft|pending|paid
        'payment_method',  // enum: card|cash|wire|pass_sport
    ];

    protected $casts = [
        'birthdate'      => 'date',
        'parent_date'    => 'date',
        'is_minor'       => 'bool',
        'rgpd'           => 'bool',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    // Helper: statut booléen payé
    public function getIsPaidAttribute(): bool
    {
        return $this->status === 'paid';
    }
}
