<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkoutTracker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'workout_type',
        'duration',
        'calories_burned',
    ];
}
