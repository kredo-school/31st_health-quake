@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Quake - Habit Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #E0F7FA;
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
   

<!-- Main Content -->
    <main class="container mx-auto px-4 pt-8rem">
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
                    <span class="text-sm">:走る男性:</span>
                </div>
                <div class="flex items-center">
                    <div class="habit-icon bg-yellow-400 mr-1"></div>
                    <span class="text-sm">:力こぶ:</span>
                </div>
                <div class="flex items-center">
                    <div class="habit-icon bg-purple-400 mr-1"></div>
                    <span class="text-sm">:複数の本:</span>
                </div>
                <div class="flex items-center">
                    <div class="habit-icon bg-blue-300 mr-1"></div>
                    <span class="text-sm">:zzz:</span>
                </div>
                <div class="flex items-center">
                    <div class="habit-icon bg-green-400 mr-1"></div>
                    <span class="text-sm">:サラダ:</span>
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


@endsection