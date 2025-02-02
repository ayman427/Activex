<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Post Content -->
        <div class="bg-white shadow rounded-lg p-6 mb-6 dark:bg-gray-800">
            <h1 class="text-2xl font-bold mb-6 dark:text-gray-200">{{ $post->title }}</h1>
            <p class="text-gray-800 mb-4 dark:text-gray-200">{{ $post->content }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Posted by 
                {{ $post->user ? $post->user->name : 'Unknown User' }} 
                on {{ $post->created_at->format('M d, Y') }}
            </p>
        </div>

        <!-- Comments Section -->
        <div class="bg-white shadow rounded-lg p-6 dark:bg-gray-800">
            <h2 class="text-lg font-bold mb-4 dark:text-gray-300">Comments</h2>

            @if($post->comments->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">No comments yet be the first one to comment.</p>
            @else
                @foreach($post->comments as $comment)
                    <div class="border-b border-gray-200 mb-4 pb-4">
                        <p class="text-gray-800 dark:text-gray-200">{{ $comment->content }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Posted by 
                            {{ $comment->user ? $comment->user->name : 'Unknown User' }} 
                            on {{ $comment->created_at->format('M d, Y') }}
                        </p>
                    </div>
                @endforeach
            @endif

            <!-- Add Comment Form -->
            <form method="POST" action="{{ route('post.comment', $post) }}">
                @csrf
                <textarea name="content" rows="3" class="w-full border rounded px-4 py-2 dark:bg-gray-900 dark:text-gray-400" required></textarea>
                <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-blue-600 mt-2">Add Comment</button>
            </form>
        </div>
    </div>

    <a href="/forum"><button class="bg-black text-white px-4 py-2 rounded hover:bg-blue-600 mt-2">Go Back To All Posts</button></a>
</x-app-layout>
