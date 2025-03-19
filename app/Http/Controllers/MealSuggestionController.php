<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MealSuggestionController extends Controller
{
    public function getMealSuggestions(Request $request)
    {
        $diet         = $request->input('diet', 'balanced');
        $calories     = $request->input('calories', 2000);
        $restrictions = $request->input('restrictions', 'none');

        if (! $request->has(['diet', 'calories'])) {
            return view('meals.suggestions')->with('meals', null);
        }

        // Shorter prompt to ensure the response fits
        $prompt = "Suggest a one-day meal plan under $calories calories for a $diet diet, avoiding $restrictions.
    Format:
    - Breakfast: [Meal name] - [Calories]calories
    - Lunch: [Meal name] - [Calories]
    - Dinner: [Meal name] - [Calories]";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.openrouter.api_key'),
            'Content-Type'  => 'application/json',
            'HTTP-Referer'  => config('app.url'),
        ])->timeout(60)->post('https://openrouter.ai/api/v1/chat/completions', [
            'model'       => 'google/gemma-3-1b-it:free', // ✅ Updated model
            'messages'    => [
                [
                    'role'    => 'user',
                    'content' => [
                        ['type' => 'text', 'text' => $prompt], // ✅ Match OpenRouter's content format
                    ],
                ],
            ],
            'temperature' => 0.7,
            'max_tokens'  => 1000,
        ]);

        if ($response->failed()) {
            return view('meals.suggestions')->with('meals', ['Error fetching meal suggestions.']);
        }

        $data = $response->json();

        $content = $data['choices'][0]['message']['content'] ?? '';

        // Ensure content is not empty
        $meals = ! empty($content) ? explode("\n", trim($content)) : ['No suggestions available.'];

        return view('meals.suggestions', compact('meals'));
    }

    public function chat(Request $request)
    {
        $userMessage = $request->input('message');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.openrouter.api_key'),
            'Content-Type'  => 'application/json',
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model'       => 'google/gemma-3-1b-it:free', // ✅ Updated to Gemma
            'messages'    => [
                ['role' => 'system', 'content' => [['type' => 'text', 'text' => 'You are a knowledgeable nutritionist and diet expert.']]],
                ['role' => 'user', 'content' => [['type' => 'text', 'text' => $userMessage]]], // ✅ Match correct content format
            ],
            'temperature' => 0.7,
            'max_tokens'  => 300,
        ]);

        $data     = $response->json();
        $botReply = $data['choices'][0]['message']['content'] ?? 'Sorry, I am unable to answer that.';

        return response()->json(['reply' => $botReply]);
    }

}
