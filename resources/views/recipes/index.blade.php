<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search Recipes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('recipes.index') }}" method="GET" class="mb-4">
                    <input type="text" name="query" class="border rounded w-full py-2 px-3" placeholder="Enter recipe name" value="{{ request('query') }}" required>
                    <button type="submit" class="mt-2 text-white font-bold py-2 px-4 rounded" style="background-color: blue;">
                        Search
                    </button>
                </form>

                @if(request()->has('query'))
                    <h2 class="text-xl font-bold mb-4">Search Results:</h2>
                    @if(isset($recipes) && count($recipes) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($recipes as $recipe)
                                <div class="border rounded-lg p-4 shadow-md">
                                    <h3 class="font-semibold text-lg">{{ $recipe['recipe']['label'] }}</h3>
                                    <img src="{{ $recipe['recipe']['image'] }}" alt="{{ $recipe['recipe']['label'] }}" class="w-full h-48 object-cover rounded-lg">
                                    <a href="{{ $recipe['recipe']['url'] }}" target="_blank" class="text-blue-500">View Recipe</a>
                                    <form action="{{ route('recipes.addToFavorites') }}" method="POST" class="mt-2">
                                        @csrf
                                        <input type="hidden" name="label" value="{{ $recipe['recipe']['label'] }}">
                                        <input type="hidden" name="image" value="{{ $recipe['recipe']['image'] }}">
                                        <input type="hidden" name="url" value="{{ $recipe['recipe']['url'] }}">
                                        <button type="submit" class="bg-black hover:bg-green-700 text-white font-bold py-1 px-2 rounded">
                                            Add to Favorites
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-red-500 font-bold">No results found for "{{ request('query') }}".</p>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
