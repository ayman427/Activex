<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalorieTracker extends Model
{
    use HasFactory;

    protected $table = 'calorie_tracker';
    
    protected $fillable = [
        'user_id', 'date', 'morning_breakfast_calories', 'lunch_calories',
        'evening_snacks_calories', 'dinner_calories', 
        'morning_breakfast_food', 'lunch_food', 'evening_snacks_food', 'dinner_food'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
