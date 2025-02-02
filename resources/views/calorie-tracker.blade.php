<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Calorie Tracker') }}
        </h2>
    </x-slot>
    <div class="card p-6">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">Quick Food Search</h2>
    <div class="flex justify-center">
        <div class="mb-4 text-center">
           <input type="text" id="food-input" class="input-field p-3 w-full md:w-80 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter a food item (e.g., 'banana', '1 slice of bread')">
           <button onclick="searchFood()" class="btn btn-primary bg-black text-white mt-4 w-full md:w-auto px-6 py-3 rounded-lg shadow-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-300">
            Search Food
           </button>
        </div>
    </div>


    
    <div id="loading" class="hidden mt-4">
        <div class="animate-pulse flex space-x-4">
            <div class="flex-1 space-y-4 py-1">
                <div class="h-4 bg-gray-700 rounded w-3/4"></div>
                <div class="space-y-2">
                    <div class="h-4 bg-gray-700 rounded"></div>
                    <div class="h-4 bg-gray-700 rounded w-5/6"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="food-info" class="mt-4 hidden"></div>
    <div id="nutritionChartContainer" class="mt-4 hidden">
        <canvas id="nutritionChart"></canvas>
    </div>
</div>
<script>
    const APP_ID = '9ed27810';
    const API_KEY = '23dec8984baa257caea8b11428d34f6b';
    const loading = document.getElementById('loading');
    const foodInfo = document.getElementById('food-info');
    const nutritionChartContainer = document.getElementById('nutritionChartContainer');
    let nutritionChart;

    async function searchFood() {
        const input = document.getElementById("food-input").value.trim();
        if (input === '') {
            alert("Please enter a food name!");
            return;
        }

        loading.classList.remove('hidden');
        foodInfo.classList.add('hidden');
        nutritionChartContainer.classList.add('hidden');

        try {
            const response = await fetch('https://trackapi.nutritionix.com/v2/natural/nutrients', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'x-app-id': APP_ID,
                    'x-app-key': API_KEY
                },
                body: JSON.stringify({ query: input })
            });

            if (!response.ok) {
                throw new Error("Food not found!");
            }

            const data = await response.json();
            if (data.foods && data.foods.length > 0) {
                displayFoodInfo(data.foods[0]);
                updateNutritionChart(data.foods[0]);
                nutritionChartContainer.classList.remove('hidden');
                nutritionChartContainer.style.display = 'block';
            } else {
                throw new Error("Food not found!");
            }
        } catch (error) {
            foodInfo.innerHTML = `<p class="text-red-500">${error.message}</p>`;
            foodInfo.classList.remove('hidden');
        } finally {
            loading.classList.add('hidden');
        }
    }

    function displayFoodInfo(food) {
        foodInfo.innerHTML = `
            <div class="space-y-2">
                <h3 class="font-semibold text-lg capitalize dark:text-gray-200">${food.food_name}</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-400">Calories</p>
                        <p class="font-medium dark:text-gray-200">${Math.round(food.nf_calories)} kcal</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Protein</p>
                        <p class="font-medium dark:text-gray-200">${Math.round(food.nf_protein)}g</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Carbs</p>
                        <p class="font-medium dark:text-gray-200">${Math.round(food.nf_total_carbohydrate)}g</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-400">Fat</p>
                        <p class="font-medium dark:text-gray-200">${Math.round(food.nf_total_fat)}g</p>
                    </div>
                </div>
            </div>
        `;
        foodInfo.classList.remove('hidden');
    }

    function updateNutritionChart(food) {
        const ctx = document.getElementById('nutritionChart').getContext('2d');
        
        if (nutritionChart) {
            nutritionChart.destroy();
        }

        nutritionChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Protein', 'Carbs', 'Fat'],
                datasets: [{
                    data: [food.nf_protein, food.nf_total_carbohydrate, food.nf_total_fat],
                    backgroundColor: ['#10B981', '#3B82F6', '#F59E0B'],
                    borderColor: '#1F2937',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#73c2fb',
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value.toFixed(1)}g (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }
</script>

    <div class="py-12 " >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 dark:bg-gray-800">
                <h3 class="text-2xl font-bold mb-4 dark:text-gray-200">Calorie Tracker for {{ now()->toDateString() }}</h3>

                @if (session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('calorie_tracker.update') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Input fields remain unchanged -->
                        <!-- Morning Breakfast -->
                        <div>
                            <label for="morning_breakfast_food" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Morning Breakfast Food</label>
                            <input type="text" name="morning_breakfast_food" id="morning_breakfast_food" 
                                   value="{{ old('morning_breakfast_food', $calories->morning_breakfast_food) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="morning_breakfast_calories" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Morning Breakfast Calories</label>
                            <input type="number" name="morning_breakfast_calories" id="morning_breakfast_calories" 
                                   value="{{ old('morning_breakfast_calories', $calories->morning_breakfast_calories) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <!-- Lunch -->
                        <div>
                            <label for="lunch_food" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Lunch Food</label>
                            <input type="text" name="lunch_food" id="lunch_food" 
                                   value="{{ old('lunch_food', $calories->lunch_food) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="lunch_calories" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Lunch Calories</label>
                            <input type="number" name="lunch_calories" id="lunch_calories" 
                                   value="{{ old('lunch_calories', $calories->lunch_calories) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <!-- Evening Snacks -->
                        <div>
                            <label for="evening_snacks_food" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Evening Snacks Food</label>
                            <input type="text" name="evening_snacks_food" id="evening_snacks_food" 
                                   value="{{ old('evening_snacks_food', $calories->evening_snacks_food) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="evening_snacks_calories" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Evening Snacks Calories</label>
                            <input type="number" name="evening_snacks_calories" id="evening_snacks_calories" 
                                   value="{{ old('evening_snacks_calories', $calories->evening_snacks_calories) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <!-- Dinner -->
                        <div>
                            <label for="dinner_food" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Dinner Food</label>
                            <input type="text" name="dinner_food" id="dinner_food" 
                                   value="{{ old('dinner_food', $calories->dinner_food) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="dinner_calories" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Dinner Calories</label>
                            <input type="number" name="dinner_calories" id="dinner_calories" 
                                   value="{{ old('dinner_calories', $calories->dinner_calories) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <button type="submit" class="mt-4 px-4 py-2 bg-black text-white rounded shadow hover:bg-blue-700 focus:outline-none">
                        Save
                    </button>
                </form>

                <h3 class="text-xl font-bold mt-6 dark:text-white">Total Calories for Today: {{ 
                    $calories->morning_breakfast_calories + 
                    $calories->lunch_calories + 
                    $calories->evening_snacks_calories + 
                    $calories->dinner_calories }}</h3>

                <div class="mt-6">
                    <canvas id="calorieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('calorieChart').getContext('2d');
        var calorieChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Breakfast', 'Lunch', 'Evening Snacks', 'Dinner'],
                datasets: [{
                    label: 'Calories',
                    data: [
                        {{ $calories->morning_breakfast_calories }},
                        {{ $calories->lunch_calories }},
                        {{ $calories->evening_snacks_calories }},
                        {{ $calories->dinner_calories }}
                    ],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var index = context.dataIndex;
                                var foods = [
                                    "{{ $calories->morning_breakfast_food }}",
                                    "{{ $calories->lunch_food }}",
                                    "{{ $calories->evening_snacks_food }}",
                                    "{{ $calories->dinner_food }}"
                                ];
                                return foods[index] + ': ' + context.raw + ' Calories';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</x-app-layout>
