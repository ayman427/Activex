<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Workout Tracker') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 dark:bg-gray-800 ">
                <form action="{{ route('workouts.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Date</label>
                        <input type="date" name="date" id="date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="workout_type" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Workout Type</label>
                        <input type="text" name="workout_type" id="workout_type" placeholder="e.g., running" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Duration (minutes)</label>
                        <input type="number" name="duration" id="duration" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white rounded-md px-4 py-2 hover:bg-indigo-700">Add Workout</button>
                </form>

                @if(session('success'))
                    <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                        {{ session('success') }}
                    </div>
                @endif

                <h2 class="mt-8 text-xl font-semibold dark:text-gray-200">Your Workouts</h2>
                <ul class="mt-4 space-y-2">
                    @foreach($workouts as $workout)
                        <li class=" p-4 rounded-md shadow-sm dark:text-gray-400">
                            {{ $workout->date }} - {{ $workout->workout_type }} ({{ $workout->duration }} mins), Estimated Calories Burned: {{ $workout->calories_burned }}kcal
                        </li>
                    @endforeach
                </ul>

                <h2 class="mt-8 text-xl font-semibold dark:text-gray-200">Workout Streak Calendar</h2>
                <div id="calendar" class="mt-4 dark:text-gray-200"></div>
            </div>
        </div>
    </div>
</x-app-layout>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: [
                @foreach ($workouts as $workout)
                {
                    title: '{{ $workout->workout_type }}',
                    start: '{{ $workout->date }}',
                    color: 'green' // Display workout streak in green
                },
                @endforeach
            ]
        });
        calendar.render();
    });
</script>
