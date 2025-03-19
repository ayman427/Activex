
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('AI-Powered Meal Suggestions') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Meal Plan Form Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl h-full">
                        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-6 sm:p-8">
                            <h3 class="text-xl font-bold text-white">Personalize Your Meal Plan</h3>
                            <p class="mt-2 text-emerald-100">Our AI will create a custom meal plan based on your preferences</p>
                        </div>

                        <div class="p-6 sm:p-8 space-y-6">
                            <form action="{{ route('meal.suggestions') }}" method="GET" class="space-y-6" id="mealForm">
                                @csrf

                                <!-- Diet Type -->
                                <div class="space-y-2">
                                    <label class="flex items-center text-gray-700 dark:text-gray-300 font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        Diet Type:
                                    </label>
                                    <select name="diet" id="diet" class="w-full border border-gray-300 dark:border-gray-600 rounded-xl py-3 px-4 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                                        <option value="keto">Keto</option>
                                        <option value="vegan">Vegan</option>
                                        <option value="vegetarian">Vegetarian</option>
                                        <option value="paleo">Paleo</option>
                                        <option value="mediterranean">Mediterranean</option>
                                    </select>
                                </div>

                                <!-- Calorie Limit -->
                                <div class="space-y-2">
                                    <label class="flex items-center text-gray-700 dark:text-gray-300 font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                        Daily Calorie Limit:
                                    </label>
                                    <input type="number" id="calories" name="calories" class="w-full border border-gray-300 dark:border-gray-600 rounded-xl py-3 px-4 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all" placeholder="e.g., 1500" required>
                                </div>

                                <!-- Meal Preference -->
                                <div class="space-y-2">
                                    <label class="flex items-center text-gray-700 dark:text-gray-300 font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                        </svg>
                                        Meal Preference:
                                    </label>
                                    <select name="preference" id="preference" class="w-full border border-gray-300 dark:border-gray-600 rounded-xl py-3 px-4 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                                        <option value="high_protein">High Protein</option>
                                        <option value="low_carb">Low Carb</option>
                                        <option value="balanced">Balanced</option>
                                        <option value="low_fat">Low Fat</option>
                                    </select>
                                </div>

                                <!-- Ingredient Restrictions -->
                                <div class="space-y-2">
                                    <label class="flex items-center text-gray-700 dark:text-gray-300 font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                        </svg>
                                        Ingredient Restrictions:
                                    </label>
                                    <input type="text" id="restrictions" name="restrictions" class="w-full border border-gray-300 dark:border-gray-600 rounded-xl py-3 px-4 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all" placeholder="e.g., No nuts, No dairy">
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-3 px-4 rounded-xl transition-all transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Generate Meal Plan
                                </button>
                            </form>

                            <!-- Loader (hidden by default) -->
                            <div id="loading" class="hidden">
                                <div class="flex items-center justify-center space-x-2 py-4">
                                    <div class="w-4 h-4 rounded-full animate-pulse bg-emerald-400"></div>
                                    <div class="w-4 h-4 rounded-full animate-pulse bg-emerald-500 delay-75"></div>
                                    <div class="w-4 h-4 rounded-full animate-pulse bg-emerald-600 delay-150"></div>
                                    <div class="w-4 h-4 rounded-full animate-pulse bg-teal-500 delay-300"></div>
                                </div>
                                <p class="text-center text-gray-600 dark:text-gray-400">Crafting your perfect meal plan...</p>
                            </div>

                            @if(isset($meals))
                                <div class="mt-8 animate-fade-in">
                                    <div class="flex items-center space-x-2 mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Your Personalized Meal Plan</h2>
                                    </div>

                                    <div class="bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-700 p-6 rounded-xl shadow-inner">
                                        <ul class="space-y-4">
                                            @foreach($meals as  $meal)
                                                <li class="flex items-start">
                                                    <span class="text-gray-700 dark:text-gray-300">{{ $meal }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Chat with AI Nutritionist Section -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl h-100 flex flex-col">
                        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 p-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white">AI Nutritionist</h3>
                                    <p class="text-xs text-teal-100">Online • Ready to help</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex-grow flex flex-col p-4">
                            <div id="chatBox" class="flex-grow overflow-y-auto bg-gray-50 dark:bg-gray-900 rounded-xl p-4 mb-4 space-y-3 min-h-[300px] max-h-[500px]">
                                <!-- Welcome message -->
                                <div class="flex items-start space-x-2">
                                    <div class="w-8 h-8 rounded-full bg-teal-100 dark:bg-teal-900 flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600 dark:text-teal-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="bg-white dark:bg-gray-800 rounded-lg rounded-tl-none p-3 shadow-sm max-w-[85%]">
                                        <p class="text-gray-700 dark:text-gray-300">Hello! I'm your AI Nutritionist. How can I help with your nutrition questions today?</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Just now</p>
                                    </div>
                                </div>
                                <!-- Chat messages will be appended here -->
                            </div>

                            <div class="flex space-x-2 relative">
                                <input type="text" id="userInput" placeholder="Ask about nutrition..." class="w-full p-3 pr-10 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all" onkeypress="if(event.key === 'Enter') sendMessage()">
                                <button onclick="sendMessage()" class="px-4 py-2 bg-gradient-to-r from-teal-500 to-cyan-500 hover:from-teal-600 hover:to-cyan-600 text-white rounded-xl flex items-center justify-center transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                Powered by advanced AI to help you achieve your nutrition goals
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('mealForm').addEventListener('submit', function() {
            document.getElementById('loading').classList.remove('hidden');
        });

        function sendMessage() {
            let userInput = document.getElementById("userInput").value;
            if (!userInput) return;

            let chatBox = document.getElementById("chatBox");

            // Add user message
            chatBox.innerHTML += `
                <div class="flex items-start justify-end space-x-2">
                    <div class="bg-teal-500 text-white rounded-lg rounded-tr-none p-3 shadow-sm max-w-[85%]">
                        <p>${userInput}</p>
                        <p class="text-xs text-teal-100 mt-1">Just now</p>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-teal-600 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </div>
            `;

            document.getElementById("userInput").value = "";
            chatBox.scrollTop = chatBox.scrollHeight;

            // Show typing indicator
            let typingId = 'typing-indicator';
            chatBox.innerHTML += `
                <div id="${typingId}" class="flex items-start space-x-2">
                    <div class="w-8 h-8 rounded-full bg-teal-100 dark:bg-teal-900 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600 dark:text-teal-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg rounded-tl-none p-3 shadow-sm">
                        <div class="flex space-x-1">
                            <div class="w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600 animate-bounce"></div>
                            <div class="w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600 animate-bounce" style="animation-delay: 0.2s"></div>
                            <div class="w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600 animate-bounce" style="animation-delay: 0.4s"></div>
                        </div>
                    </div>
                </div>
            `;
            chatBox.scrollTop = chatBox.scrollHeight;

            // Send message to server
            axios.post("/chat", { message: userInput })
                .then(response => {
                    // Remove typing indicator
                    document.getElementById(typingId).remove();

                    // Add AI response
                    chatBox.innerHTML += `
                        <div class="flex items-start space-x-2">
                            <div class="w-8 h-8 rounded-full bg-teal-100 dark:bg-teal-900 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600 dark:text-teal-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="bg-white dark:bg-gray-800 rounded-lg rounded-tl-none p-3 shadow-sm max-w-[85%]">
                                <p class="text-gray-700 dark:text-gray-300">${response.data.reply}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Just now</p>
                            </div>
                        </div>
                    `;
                    chatBox.scrollTop = chatBox.scrollHeight;
                })
                .catch(error => {
                    // Remove typing indicator
                    document.getElementById(typingId).remove();

                    // Show error message
                    chatBox.innerHTML += `
                        <div class="flex items-start space-x-2">
                            <div class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 dark:text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="bg-white dark:bg-gray-800 rounded-lg rounded-tl-none p-3 shadow-sm">
                                <p class="text-red-500">Sorry, I couldn't process your request. Please try again.</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Just now</p>
                            </div>
                        </div>
                    `;
                    chatBox.scrollTop = chatBox.scrollHeight;
                    console.error(error);
                });
        }

        // Enable dark mode toggle if needed
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
        }

        // Check for saved theme preference or respect OS preference
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }

        /* Custom scrollbar for chat */
        #chatBox::-webkit-scrollbar {
            width: 6px;
        }

        #chatBox::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        #chatBox::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        #chatBox::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.2);
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            #chatBox {
                min-height: 250px;
                max-height: 350px;
            }
        }
    </style>
</x-app-layout>
