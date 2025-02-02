<?php
namespace App\Http\Controllers;

use App\Models\UserWeight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WeightTrackerController extends Controller
{
    public function index()
    {
        // Fetching the user's weights
        $weights = UserWeight::where('user_id', auth()->id())->get();

        // Fetching the user's latest goal weight from the user's weights table
        $goal_weight = UserWeight::where('user_id', auth()->id())->latest()->first()->goal_weight ?? 0; // Default to 0 if no goal weight is set

        $formattedDates = $weights->pluck('created_at')->map(function($date) {
            return $date->format('Y-m-d');
        });

        return view('weight-tracker', compact('weights', 'goal_weight','formattedDates'));
    }

    public function store(Request $request)
{
    // Validate input
    $request->validate([
        'weight' => 'nullable|numeric|min:1',
        'goal_weight' => 'nullable|numeric|min:1',
    ]);

    // Get today's date
    $today = Carbon::today();

    // Fetch the latest goal weight of the user
    $latestGoalWeight = UserWeight::where('user_id', Auth::id())
                                  ->whereNotNull('goal_weight')
                                  ->latest()
                                  ->value('goal_weight');

    // Check if a weight entry already exists for today
    $existingWeight = UserWeight::where('user_id', Auth::id())
                                ->whereDate('date', $today)
                                ->first();

    if ($request->has('weight')) {
        if ($existingWeight) {
            // Update existing entry
            $existingWeight->update([
                'weight' => $request->weight,
                'goal_weight' => $request->goal_weight ?? $existingWeight->goal_weight ?? $latestGoalWeight, 
            ]);
        } else {
            // Create a new entry, keeping the latest goal weight if not provided
            UserWeight::create([
                'user_id' => Auth::id(),
                'weight' => $request->weight,
                'goal_weight' => $request->goal_weight ?? $latestGoalWeight,
                'date' => $today,
            ]);
        }
    }

    // If only goal weight is provided, update or create an entry
    if ($request->has('goal_weight')) {
        if ($existingWeight) {
            $existingWeight->update([
                'goal_weight' => $request->goal_weight,
            ]);
        } else {
            UserWeight::create([
                'user_id' => Auth::id(),
                'goal_weight' => $request->goal_weight,
                'weight' => null, // Ensuring no weight entry if weight is not provided
                'date' => $today,
            ]);
        }
    }

    return redirect()->route('weight-tracker.index');
}
}
