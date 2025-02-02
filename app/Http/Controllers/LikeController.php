<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request, Post $post)
    {
        Like::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Liked successfully!');
    }
}
