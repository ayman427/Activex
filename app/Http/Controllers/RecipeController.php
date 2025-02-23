<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller {
    // Show Search Page and Handle Search Request
    public function index(Request $request) {
        $recipes = [];

        // Check if a search query is present
        if ($request->has('query')) {
            $query = $request->input('query');
            $response = Http::get('https://api.edamam.com/search', [
                'q' => $query,
                'app_id' => env('EDAMAM_APP_ID'),
                'app_key' => env('EDAMAM_APP_KEY'),
            ]);

            $recipes = $response->json()['hits'];
        }

        return view('recipes.index', compact('recipes'));
    }

    // Add to Favorites
    public function addToFavorites(Request $request) {
        Favorite::create([
            'user_id' => Auth::id(),
            'label' => $request->input('label'),
            'image' => $request->input('image'),
            'url' => $request->input('url')
        ]);

        return redirect()->back()->with('success', 'Recipe added to favorites!');
    }

    // View Favorites
    public function viewFavorites() {
        $favorites = Favorite::where('user_id', Auth::id())->get();
        return view('recipes.favorites', compact('favorites'));
    }

    // Delete a Favorite Recipe
public function deleteFavorite($id) {
    $favorite = Favorite::where('id', $id)->where('user_id', Auth::id())->first();

    if ($favorite) {
        $favorite->delete();
        return redirect()->back()->with('success', 'Recipe removed from favorites!');
    }

    return redirect()->back()->with('error', 'Recipe not found or not authorized!');
}

}
