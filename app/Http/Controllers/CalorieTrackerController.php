<?php

namespace App\Http\Controllers;

use App\Models\CalorieTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalorieTrackerController extends Controller
{
    public function index()
    {
        $calories = CalorieTracker::where('user_id', auth()->id())
                                  ->where('date', now()->toDateString())
                                  ->first();

        if (!$calories) {
            // Create an entry if not found
            $calories = CalorieTracker::create([
                'user_id' => auth()->id(),
                'date' => now()->toDateString(),
                'morning_breakfast_calories' => 0,
                'lunch_calories' => 0,
                'evening_snacks_calories' => 0,
                'dinner_calories' => 0,
                'morning_breakfast_food' => '',
                'lunch_food' => '',
                'evening_snacks_food' => '',
                'dinner_food' => ''
            ]);
        }

        return view('calorie-tracker', compact('calories'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'morning_breakfast_calories' => 'required|integer',
            'lunch_calories' => 'required|integer',
            'evening_snacks_calories' => 'required|integer',
            'dinner_calories' => 'required|integer',
            'morning_breakfast_food' => 'nullable|string|max:255',
            'lunch_food' => 'nullable|string|max:255',
            'evening_snacks_food' => 'nullable|string|max:255',
            'dinner_food' => 'nullable|string|max:255',
        ]);

        $calories = CalorieTracker::where('user_id', auth()->id())
                                  ->where('date', now()->toDateString())
                                  ->first();

        if ($calories) {
            // Append new values to the existing record
            $calories->update([
                'morning_breakfast_calories' => $calories->morning_breakfast_calories + $validated['morning_breakfast_calories'],
                'lunch_calories' => $calories->lunch_calories + $validated['lunch_calories'],
                'evening_snacks_calories' => $calories->evening_snacks_calories + $validated['evening_snacks_calories'],
                'dinner_calories' => $calories->dinner_calories + $validated['dinner_calories'],
                'morning_breakfast_food' => $calories->morning_breakfast_food 
                    ? $calories->morning_breakfast_food . ', ' . $validated['morning_breakfast_food'] 
                    : $validated['morning_breakfast_food'],
                'lunch_food' => $calories->lunch_food 
                    ? $calories->lunch_food . ', ' . $validated['lunch_food'] 
                    : $validated['lunch_food'],
                'evening_snacks_food' => $calories->evening_snacks_food 
                    ? $calories->evening_snacks_food . ', ' . $validated['evening_snacks_food'] 
                    : $validated['evening_snacks_food'],
                'dinner_food' => $calories->dinner_food 
                    ? $calories->dinner_food . ', ' . $validated['dinner_food'] 
                    : $validated['dinner_food'],
            ]);
        } else {
            // Create a new record if none exists
            CalorieTracker::create([
                'user_id' => auth()->id(),
                'date' => now()->toDateString(),
                'morning_breakfast_calories' => $validated['morning_breakfast_calories'],
                'lunch_calories' => $validated['lunch_calories'],
                'evening_snacks_calories' => $validated['evening_snacks_calories'],
                'dinner_calories' => $validated['dinner_calories'],
                'morning_breakfast_food' => $validated['morning_breakfast_food'],
                'lunch_food' => $validated['lunch_food'],
                'evening_snacks_food' => $validated['evening_snacks_food'],
                'dinner_food' => $validated['dinner_food'],
            ]);
        }

        $graphData = [
            [
                'label' => "Morning Breakfast: {$calories->morning_breakfast_food}",
                'calories' => $calories->morning_breakfast_calories
            ],
            [
                'label' => "Lunch: {$calories->lunch_food}",
                'calories' => $calories->lunch_calories
            ],
            [
                'label' => "Evening Snacks: {$calories->evening_snacks_food}",
                'calories' => $calories->evening_snacks_calories
            ],
            [
                'label' => "Dinner: {$calories->dinner_food}",
                'calories' => $calories->dinner_calories
            ],
        ];

        return redirect()->route('calorie-tracker.index')->with('success', 'Calories and food names updated successfully');
    }
}
