<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Community Forum') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">
        <!-- Post Creation Form -->
        <div class="bg-white shadow rounded-lg p-6 mb-6 dark:bg-gray-800">
            <h2 class="text-xl font-semibold mb-4 dark:text-gray-200">Create a New Post</h2>
            <form method="POST" action="{{ route('posts.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block font-semibold dark:text-gray-200">Title</label>
                    <input type="text" id="title" name="title" class="w-full border rounded px-4 py-2 dark:bg-gray-900 dark:text-gray-400" required>
                </div>
                <div class="mb-4">
                    <label for="content" class="block font-semibold dark:text-gray-200">Content</label>
                    <textarea id="content" name="content" rows="4" class="w-full border rounded px-4 py-2 dark:bg-gray-900 dark:text-gray-400" required></textarea>
                </div>
                <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-blue-600">
                    Post
                </button>
            </form>
        </div>

        <!-- Displaying All Posts -->
        @if($posts->isEmpty())
            <p class="text-gray-500">No posts yet, be the first one to post.</p>
        @else
            @foreach($posts as $post)
                <div class="bg-white shadow rounded-lg p-6 mb-6 dark:bg-gray-800">
                    <h2 class="text-xl font-semibold">
                        <a href="{{ route('post.show', $post) }}" class="text-blue-500 dark:text-gray-200">
                            {{ $post->title }}
                        </a>
                    </h2>
                    <p class="text-gray-600 mb-2 dark:text-gray-200">{{ $post->content }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Posted by {{ $post->user->name }} on {{ $post->created_at->format('M d, Y') }}</p>
                </div>
            @endforeach
        @endif

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
