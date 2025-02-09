<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $latestWeight = DB::table('user_weights')
        ->where('user_id', Auth::id())
        ->latest('created_at')  // Get the latest entry based on created_at timestamp
        ->first();

        $latestCalories = DB::table('calorie_tracker')
        ->where('user_id', $user->id)
        ->latest('created_at')
        ->first();

    // Calculate total daily calorie intake
    $totalCalories = 0;
    if ($latestCalories) {
        $totalCalories = 
            ($latestCalories->morning_breakfast_calories ?? 0) +
            ($latestCalories->lunch_calories ?? 0) +
            ($latestCalories->evening_snacks_calories ?? 0) +
            ($latestCalories->dinner_calories ?? 0);
    }

    $latestPosts = Post::with('user')
            ->latest()
            ->take(3)
            ->get();

        return view('dashboard', compact('user','latestWeight','totalCalories','latestPosts'));
    }
}
