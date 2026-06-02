<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'level',
        'is_active',
    ];

    public function timeslots()
    {
        return $this->hasMany(Timeslot::class);
    }
}
