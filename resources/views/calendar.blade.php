<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Quake - Habit Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa;
        }
        .habit-icon {
            width: 24px;
            height: 24px;
            display: inline-block;
            border-radius: 4px;
        }
        .calendar-cell {
            width: 100%;
            aspect-ratio: 1;
            border: 1px solid #ccc;
            border-radius: 4px;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        .habit-marker {
            width: 50%;
            height: 50%;
            position: absolute;
        }
        .habit-marker-tl {
            top: 0;
            left: 0;
            border-top-left-radius: 4px;
        }
        .habit-marker-tr {
            top: 0;
            right: 0;
            border-top-right-radius: 4px;
        }
        .habit-marker-bl {
            bottom: 0;
            left: 0;
            border-bottom-left-radius: 4px;
        }
        .habit-marker-br {
            bottom: 0;
            right: 0;
            border-bottom-right-radius: 4px;
        }
    </style>
</head>
<body>
    <!-- Header/Navigation -->
    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex items-center mr-12">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="ml-2">
                        <div class="font-bold text-green-600">HEALTH</div>
                        <div class="font-bold text-green-600 -mt-1">QUAKE</div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="#" class="font-medium text-gray-700">Home</a>
                    <a href="#" class="font-medium text-gray-900 font-bold">Calendar</a>
                    <a href="#" class="font-medium text-gray-700">Task</a>
                    <a href="#" class="font-medium text-gray-700">Ranking</a>
                </nav>
            </div>

            <!-- User Profile -->
            <div class="w-10 h-10 bg-pink-500 rounded-full overflow-hidden">
                <div class="w-full h-full bg-pink-600"></div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
        <!-- Habit History Section -->
        <section class="bg-white rounded-lg shadow-sm p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-light text-gray-200">habits history</h2>
                <h2 class="text-3xl font-medium text-green-700">March</h2>
            </div>

            <!-- Habit Icons -->
            <div class="flex space-x-4 mb-8">
                <div class="flex items-center">
                    <div class="habit-icon bg-red-400 mr-1"></div>
                    <span class="text-sm">🏃‍♂️</span>
                </div>
                <div class="flex items-center">
                    <div class="habit-icon bg-yellow-400 mr-1"></div>
                    <span class="text-sm">💪</span>
                </div>
                <div class="flex items-center">
                    <div class="habit-icon bg-purple-400 mr-1"></div>
                    <span class="text-sm">📚</span>
                </div>
                <div class="flex items-center">
                    <div class="habit-icon bg-blue-300 mr-1"></div>
                    <span class="text-sm">💤</span>
                </div>
                <div class="flex items-center">
                    <div class="habit-icon bg-green-400 mr-1"></div>
                    <span class="text-sm">🥗</span>
                </div>

            </div>

            <!-- Calendar -->
            <div class="calendar">
                <!-- Days of Week -->
                <div class="grid grid-cols-7 gap-2 mb-2 text-center text-sm text-gray-500">
                    <div>SUN</div>
                    <div>MON</div>
                    <div>TUE</div>
                    <div>WED</div>
                    <div>THU</div>
                    <div>FRI</div>
                    <div>SAT</div>
                </div>

                <!-- Week 1 -->
                <div class="grid grid-cols-7 gap-2 mb-2">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">1</div>
                        <div class="habit-marker habit-marker-tl bg-blue-400"></div>
                        <div class="habit-marker habit-marker-tr bg-purple-400"></div>
                        <div class="habit-marker habit-marker-bl bg-green-400"></div>
                        <div class="habit-marker habit-marker-br bg-orange-400"></div>
                    </div>
                </div>

                <!-- Week 2 -->
                <div class="grid grid-cols-7 gap-2 mb-2">
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">2</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">3</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">4</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">5</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">6</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">7</div>
                        <div class="habit-marker habit-marker-tl bg-blue-400"></div>
                        <div class="habit-marker habit-marker-br bg-orange-400"></div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">8</div>
                    </div>
                </div>

                <!-- Week 3 -->
                <div class="grid grid-cols-7 gap-2 mb-2">
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">9</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">10</div>
                        <div class="habit-marker habit-marker-bl bg-green-400"></div>
                        <div class="habit-marker habit-marker-br bg-orange-400"></div>
                        <div class="habit-marker habit-marker-tr bg-purple-400"></div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">11</div>
                        <div class="habit-marker habit-marker-tl bg-blue-400"></div>
                        <div class="habit-marker habit-marker-bl bg-green-400"></div>
                        <div class="habit-marker habit-marker-tr bg-purple-400"></div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">12</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">13</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">14</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">15</div>
                    </div>
                </div>

                <!-- Week 4 -->
                <div class="grid grid-cols-7 gap-2 mb-2">
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">16</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">17</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">18</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">19</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">20</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">21</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">22</div>
                    </div>
                </div>

                <!-- Week 5 -->
                <div class="grid grid-cols-7 gap-2 mb-2">
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">23</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">24</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">25</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">26</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">27</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">28</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">29</div>
                    </div>
                </div>

                <!-- Week 6 (if needed) -->
                <div class="grid grid-cols-7 gap-2">
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">30</div>
                    </div>
                    <div class="calendar-cell">
                        <div class="absolute top-1 left-1 text-xs">31</div>
                    </div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
