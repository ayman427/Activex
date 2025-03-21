<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
             <x-welcome :latestWeight="$latestWeight" :totalCalories="$totalCalories" :latestPosts="$latestPosts"/>
            </div>
        </div>
    </div>
</x-app-layout>
