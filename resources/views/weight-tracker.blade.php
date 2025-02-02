<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Weight Tracker') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Weight Input Card -->
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6 dark:bg-gray-800">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 dark:text-gray-200">Add New Weight</h3>
                        <form action="{{ url('/weight-tracker') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="flex space-x-4">
                                <input type="number" name="weight" class="flex-1 border border-gray-300 p-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter your weight (kg)" required step="0.1">
                                <button type="submit" class="bg-black hover:bg-blue-600 text-white font-semibold py-2 px-4 transition duration-300 ease-in-out transform hover:scale-105">
                                    Add Weight
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Goal Weight Card -->
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6 dark:bg-gray-800">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 dark:text-gray-200">Set Goal Weight</h3>
                        <form action="{{ url('/weight-tracker') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="flex space-x-4">
                                <input type="number" name="goal_weight" class="flex-1 border border-gray-300 p-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter your goal weight (kg)" value="{{ old('goal_weight', $goal_weight) }}" step="0.1">
                                <button type="submit" class="bg-black hover:bg-green-600 text-white font-semibold py-2 px-4 transition duration-300 ease-in-out transform hover:scale-105">
                                    Set Goal
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Progress Ring Card -->
                    @if($goal_weight && $weights->isNotEmpty())
                        @php
                            $latest_weight = $weights->last()->weight; // Get the most recent weight
                            $progress = 0;

                            // Calculate progress percentage to the goal
                            if ($goal_weight > $latest_weight) {
                                $progress = (($latest_weight - $weights->first()->weight) / ($goal_weight - $weights->first()->weight)) * 100;
                            } else {
                                $progress = (($weights->first()->weight - $latest_weight) / ($weights->first()->weight - $goal_weight)) * 100;
                            }

                            // Ensure the progress doesn't exceed 100%
                            $progress = max(0, min(100, $progress));
                        @endphp
                        <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6 dark:bg-gray-800">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 dark:text-gray-200">Progress to Goal</h3>
                            <div class="flex justify-center items-center dark:text-gray-200">
                                <div class="relative">
                                    <svg class="w-48 h-48 transform -rotate-90">
                                        <circle class="text-gray-200" stroke-width="12" stroke="currentColor" fill="transparent" r="90" cx="96" cy="96" />
                                        <circle class="text-blue-500 progress-ring" stroke-width="12" stroke-linecap="round" stroke="currentColor" fill="transparent" r="90" cx="96" cy="96" 
                                                stroke-dasharray="565.48" stroke-dashoffset="{{ 565.48 - (565.48 * ($progress / 100)) }}" />
                                    </svg>
                                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
                                        <div class="text-3xl font-bold text-blue-500">{{ number_format($progress, 1) }}%</div>
                                        <div class="text-sm text-gray-500">to goal</div>
                                        <div class="text-sm font-semibold text-gray-300">(<span class="goal-weight">{{ number_format($goal_weight, 1) }}</span> kg)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Weight Chart Card -->
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6 dark:bg-gray-800">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 dark:text-gray-200">Weight History</h3>
                        @if($weights->isEmpty())
                            <p class="text-center text-gray-500">No data available</p>
                        @else
                            <div class="mb-8">
                                <canvas id="weightChart"></canvas>
                            </div>
                        @endif
                    </div>

                    <!-- Summary Card -->
                    <div class="bg-white overflow-hidden shadow-xl rounded-lg p-6 dark:bg-gray-800">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 dark:text-gray-200">Summary</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <p class="text-sm text-gray-500">First Weight</p>
                                <p class="text-xl font-bold text-gray-800 dark:text-white"><span>{{ number_format($weights->first()->weight ?? 0, 1) }} kg</span></p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-500">Latest Weight</p>
                                <p class="text-xl font-bold text-gray-800 dark:text-white"><span>{{ number_format($weights->last()->weight ?? 0, 1) }} kg</span></p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-500">Total Change</p>
                                <p class="text-xl font-bold text-gray-800 dark:text-white">
                                    @if($weights->first() && $weights->last())
                                        {{ number_format($weights->last()->weight - $weights->first()->weight, 1) }} kg
                                    @else
                                        0 kg
                                    @endif
                                </p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-500">Goal Weight</p>
                                <p class="text-xl font-bold text-gray-800 dark:text-white"><span>{{ number_format($goal_weight ?? 0, 1) }} kg</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const weightData = @json($weights->pluck('weight'));
            const weightDates = @json($formattedDates);

            if (weightData.length > 0 && weightDates.length > 0) {
                const ctx = document.getElementById('weightChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: weightDates,
                        datasets: [{
                            label: 'Weight (kg)',
                            data: weightData,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 2,
                            tension: 0.4,
                            pointBackgroundColor: '#3b82f6',
                            pointRadius: 4,
                            pointHoverRadius: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Weight (kg)'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
