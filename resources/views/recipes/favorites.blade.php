<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Your Favorite Recipes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if($favorites->isEmpty())
                    <p>You have no favorite recipes yet.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($favorites as $favorite)
                            <div class="border rounded-lg p-4 shadow-md">
                                <h3 class="font-semibold text-lg">{{ $favorite->label }}</h3>
                                <img src="{{ $favorite->image }}" alt="{{ $favorite->label }}" class="w-full h-48 object-cover rounded-lg">
                                <a href="{{ $favorite->url }}" target="_blank" class="text-blue-500">View Recipe</a>
                                <form action="{{ route('recipes.deleteFavorite', $favorite->id) }}" method="POST" class="mt-2">
                                   @csrf
                                   @method('DELETE')
                                   <button type="submit" class=" hover:bg-red-700 text-white font-bold py-1 px-2 rounded" style="background-color: red;">
                                      Delete
                                    </button>
                                   </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
