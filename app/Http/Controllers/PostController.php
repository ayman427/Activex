<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user', 'comments.user')->latest()->paginate(5);
        return view('forum.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post->load('user', 'comments.user');
        return view('forum.show', compact('post'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('post.show', $post->id)->with('success', 'Post created successfully!');
    }

    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $post->comments()->create([
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return back();
    }
    public function userPosts()
{
    // Fetch posts made by the logged-in user
    $posts = auth()->user()->posts;

    return view('forum.user-posts', compact('posts'));
}

// app/Http/Controllers/PostController.php

public function edit($id)
{
    // Get the post by ID (only for the logged-in user)
    $post = auth()->user()->posts()->findOrFail($id);

    return view('forum.edit-post', compact('post'));
}

public function update(Request $request, $id)
{
    // Validate the incoming request data
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    // Get the post by ID and update it
    $post = auth()->user()->posts()->findOrFail($id);
    $post->update([
        'title' => $request->title,
        'content' => $request->content,
    ]);

    return redirect()->route('user.posts')->with('success', 'Post updated successfully!');
}

public function destroy($id)
{
    // Find the post and delete it (only if the user is the owner)
    $post = auth()->user()->posts()->findOrFail($id);
    $post->delete();

    return redirect()->route('user.posts')->with('success', 'Post deleted successfully!');
}

}
