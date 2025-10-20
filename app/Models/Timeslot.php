<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'weekday',
        'start',
        'end',
        'location',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
