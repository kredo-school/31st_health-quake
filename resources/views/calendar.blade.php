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
        .date-number {
            position: absolute;
            top: 1px;
            left: 1px;
            font-size: 0.75rem;
            z-index: 10;
            font-weight: 500;
        }
        .category-header {
            background-color: #0066cc;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .category-item {
            padding: 8px 12px;
            border-radius: 4px;
            background-color: white;
            margin-bottom: 5px;
            border-left: 4px solid;
            color: #666;
        }
        .for-example {
            font-style: italic;
            color: #888;
            margin-bottom: 10px;
            padding: 8px 12px;
        }
        .exercise {
            border-color: #ef4444;
        }
        .nutrition {
            border-color: #84cc16;
        }
        .sleep {
            border-color: #3b82f6;
        }
        .other {
            border-color: #a855f7;
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
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Category Panel (Left Side) -->
            <div class="md:col-span-1">
                <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                    <div class="category-header">Exercise</div>
                    <div class="for-example">for example:</div>
                    <div class="category-item exercise">🏃‍♂️ Running</div>
                    <div class="category-item exercise">💪 Strength Training</div>
                    <div class="category-item exercise">🧘 Yoga</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                    <div class="category-header">Nutrition</div>
                    <div class="for-example">for example:</div>
                    <div class="category-item nutrition">🥗 Healthy Meal</div>
                    <div class="category-item nutrition">💧 Water Intake</div>
                    <div class="category-item nutrition">🍫 No Snacks</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                    <div class="category-header">Sleep</div>
                    <div class="for-example">for example:</div>
                    <div class="category-item sleep">🛌 Early to Bed</div>
                    <div class="category-item sleep">💤 8+ Hours</div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="category-header">Other</div>
                    <div class="for-example">for example:</div>
                    <div class="category-item other">📚 Reading</div>
                    <div class="category-item other">🧠 Meditation</div>
                </div>
            </div>

            <!-- Habit History Section (Right Side) -->
            <section class="bg-white rounded-lg shadow-sm p-6 mb-8 md:col-span-3">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-3xl font-light text-gray-200">habits history</h2>
                    <h2 class="text-3xl font-medium text-green-700">March</h2>
                </div>

                <!-- Habit Icons Legend -->
                <div class="flex space-x-4 mb-8">
                    <div class="flex items-center">
                        <div class="habit-icon bg-red-400 mr-1"></div>
                        <span class="text-sm">Exercise</span>
                    </div>
                    <div class="flex items-center">
                        <div class="habit-icon bg-green-400 mr-1"></div>
                        <span class="text-sm">Nutrition</span>
                    </div>
                    <div class="flex items-center">
                        <div class="habit-icon bg-blue-400 mr-1"></div>
                        <span class="text-sm">Sleep</span>
                    </div>
                    <div class="flex items-center">
                        <div class="habit-icon bg-purple-400 mr-1"></div>
                        <span class="text-sm">Other</span>
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
                            <span class="date-number">1</span>
                        </div>
                    </div>

                    <!-- Week 2 -->
                    <div class="grid grid-cols-7 gap-2 mb-2">
                        <div class="calendar-cell">
                            <span class="date-number">2</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">3</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">4</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">5</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">6</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">7</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">8</span>
                        </div>
                    </div>

                    <!-- Week 3 -->
                    <div class="grid grid-cols-7 gap-2 mb-2">
                        <div class="calendar-cell">
                            <span class="date-number">9</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">10</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">11</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">12</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">13</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">14</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">15</span>
                        </div>
                    </div>

                    <!-- Week 4 -->
                    <div class="grid grid-cols-7 gap-2 mb-2">
                        <div class="calendar-cell">
                            <span class="date-number">16</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">17</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">18</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">19</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">20</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">21</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">22</span>
                        </div>
                    </div>

                    <!-- Week 5 -->
                    <div class="grid grid-cols-7 gap-2 mb-2">
                        <div class="calendar-cell">
                            <span class="date-number">23</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">24</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">25</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">26</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">27</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">28</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">29</span>
                        </div>
                    </div>

                    <!-- Week 6 (if needed) -->
                    <div class="grid grid-cols-7 gap-2">
                        <div class="calendar-cell">
                            <span class="date-number">30</span>
                        </div>
                        <div class="calendar-cell">
                            <span class="date-number">31</span>
                        </div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
