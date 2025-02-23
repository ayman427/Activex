<?php
namespace App\Http\Controllers;

use App\Models\WorkoutTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class WorkoutTrackerController extends Controller
{
    public function index()
    {
        $workouts = WorkoutTracker::where('user_id', Auth::id())->get();
        return view('workouts.index', compact('workouts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'workout_type' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
        ]);

        $client = new Client();
        $response = $client->request('GET', config('services.ninjas.base_url'), [
            'headers' => [
                'X-Api-Key' => config('services.ninjas.key')
            ],
            'query' => [
                'activity' => $request->workout_type,
                'duration' => $request->duration
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        $calories_burned = $data[0]['calories_per_hour'] * ($request->duration / 60);

        WorkoutTracker::create([
            'user_id' => Auth::id(),
            'date' => $request->date,
            'workout_type' => $request->workout_type,
            'duration' => $request->duration,
            'calories_burned' => round($calories_burned),
        ]);

        return redirect()->back()->with('success', 'Workout recorded successfully!');
    }
}
