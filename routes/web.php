<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeightTrackerController;
use App\Http\Controllers\CalorieTrackerController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\WorkoutTrackerController;
use App\Http\Controllers\MealSuggestionController;
use App\Models\User;  
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/weight-tracker', [WeightTrackerController::class, 'index'])->name('weight-tracker.index');
    Route::post('/weight-tracker', [WeightTrackerController::class, 'store']);


    Route::get('/calorie-tracker', [CalorieTrackerController::class, 'index'])->name('calorie-tracker.index');
    Route::post('/calorie-tracker', [CalorieTrackerController::class, 'update'])->name('calorie_tracker.update');

    Route::get('/forum', [PostController::class, 'index'])->name('forum.index');
    Route::get('/post/{post}', [PostController::class, 'show'])->name('post.show');
    Route::post('/post/{post}/comment', [PostController::class, 'comment'])->name('post.comment');
    Route::resource('posts', PostController::class);

    Route::get('/my-posts', [PostController::class, 'userPosts'])->name('user.posts');
    Route::get('/post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::put('/post/{post}', [PostController::class, 'update'])->name('post.update');
    
    // Route to delete a post
    Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('post.delete');


   // routes/web.php
    Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
    Route::post('/recipes/favorite', [RecipeController::class, 'addToFavorites'])->name('recipes.addToFavorites');
    Route::get('/favorites', [RecipeController::class, 'viewFavorites'])->name('recipes.favorites');
    Route::delete('/recipes/favorite/{id}', [RecipeController::class, 'deleteFavorite'])->name('recipes.deleteFavorite');


    Route::get('/workouts', [WorkoutTrackerController::class, 'index'])->name('workouts.index');
    Route::post('/workouts', [WorkoutTrackerController::class, 'store'])->name('workouts.store');

   

    Route::get('/meal-suggestions', [MealSuggestionController::class, 'getMealSuggestions'])->name('meal.suggestions');
    Route::post('/chat', [MealSuggestionController::class, 'chat']);


    
});

