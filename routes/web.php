<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeightTrackerController;
use App\Http\Controllers\CalorieTrackerController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\DashboardController;
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
    
});

