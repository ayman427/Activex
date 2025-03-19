<!-- resources/views/forum/edit-post.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="container max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <form method="POST" action="{{ route('post.update', $post) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block font-semibold dark:text-gray-200">Title</label>
                <input type="text" id="title" name="title" class="w-full border rounded px-4 py-2 dark:bg-gray-800 dark:text-gray-400" value="{{ old('title', $post->title) }}" required>
            </div>

            <div class="mb-4">
                <label for="content" class="block font-semibold dark:text-gray-200">Content</label>
                <textarea id="content" name="content" rows="4" class="w-full border rounded px-4 py-2 dark:bg-gray-800 dark:text-gray-400" required>{{ old('content', $post->content) }}</textarea>
            </div>

            <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:bg-blue-600">
                Update Post
            </button>
        </form>
    </div>
</x-app-layout>
