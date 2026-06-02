<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Enrollment extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'birthdate',
        'plan_id', 'status', 'payment_method', 'dossier_ref'
    ];

    protected static function booted()
    {
        static::creating(function ($enrollment) {
            if (empty($enrollment->dossier_ref)) {
                // exemple : ENR-7F3A9C2D
                $enrollment->dossier_ref = 'ENR-' . strtoupper(Str::random(8));
            }
        });
    }

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
