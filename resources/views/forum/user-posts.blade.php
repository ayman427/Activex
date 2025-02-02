<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Posts') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-8">

        @if($posts->isEmpty())
            <p class="text-gray-500 dark:text-gray-200">You haven't made any posts yet.</p>
        @else
            @foreach($posts as $post)
                <div class="bg-white shadow rounded-lg p-6 mb-6 dark:bg-gray-800">
                    <h2 class="text-xl font-semibold">
                        <a href="{{ route('post.show', $post) }}" class="text-blue-500 dark:text-gray-200">
                            {{ $post->title }}
                        </a>
                    </h2>
                    <p class="text-gray-600 mb-2 dark:text-gray-200">{{ $post->content }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Posted on {{ $post->created_at->format('M d, Y') }}</p>

                    <!-- Edit and Delete Buttons -->
                    <div class="mt-4 flex space-x-4">
                        <!-- Edit Button with Google Material Icon -->
                        <a href="{{ route('post.edit', $post) }}" class="text-black px-4 py-2 rounded hover:bg-blue-600 flex items-center" style="background-color: #2563eb; margin-right:5px">
                            <span class="material-icons">edit</span>
                        </a>
                        
                        <!-- Delete Button with Google Material Icon -->
                        <form method="POST" action="{{ route('post.delete', $post) }}" class="inline-block" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-black px-4 py-2 rounded hover:bg-blue-600 flex items-center" style="background-color: #d62828;">
                                <span class="material-icons">delete</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <script>
        // JavaScript function to confirm deletion
        function confirmDelete() {
            return confirm("Are you sure you want to delete this post?");
        }
    </script>
</x-app-layout>
