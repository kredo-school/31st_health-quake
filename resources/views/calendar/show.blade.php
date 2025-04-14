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
            padding-top: 60px; /* ナビゲーションバーの高さ分の余白 */
        }
        body {
            overflow: auto; /* 必要に応じてスクロールを有効化 */
        }
        main {
            margin-top: 420px; /* ナビゲーションバーの高さ分の余白 */
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
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <!-- Category Panel (Left Side) -->
            <div class="md:col-span-1">
                <div class="for-example">for example:</div>
                <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                    <div class="category-header">Exercise</div>
                    <div class="category-item exercise">🏃‍♂️ Running</div>
                    <div class="category-item exercise">💪 Strength Training</div>
                    <div class="category-item exercise">🧘 Yoga</div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                    <div class="category-header">Nutrition</div>
                    <div class="category-item nutrition">🥗 Healthy Meal</div>
                    <div class="category-item nutrition">💧 Water Intake</div>
                    <div class="category-item nutrition">🍫 No Snacks</div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                    <div class="category-header">Sleep</div>
                    <div class="category-item sleep">🛌 Early to Bed</div>
                    <div class="category-item sleep">💤 8+ Hours</div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="category-header">Other</div>
                    <div class="category-item other">📚 Reading</div>
                    <div class="category-item other">🧠 Meditation</div>
                </div>
            </div>

            <!-- Right Panel (Calendar) -->
            <section class="bg-white rounded-lg shadow-sm p-6 mb-8 md:col-span-4">
                <!-- Legend -->
                <div class="flex space-x-4 mb-8">
                    <div class="flex items-center"><div class="habit-icon bg-red-400 mr-1"></div><span class="text-sm">Exercise</span></div>
                    <div class="flex items-center"><div class="habit-icon bg-green-400 mr-1"></div><span class="text-sm">Nutrition</span></div>
                    <div class="flex items-center"><div class="habit-icon bg-blue-400 mr-1"></div><span class="text-sm">Sleep</span></div>
                    <div class="flex items-center"><div class="habit-icon bg-purple-400 mr-1"></div><span class="text-sm">Other</span></div>
                </div>

                <!-- Navigation -->
                <div class="flex justify-between items-center mb-6">
                    @php
                        $current = \Carbon\Carbon::create($year ?? now()->year, $month ?? now()->month, 1);
                        $prev = $current->copy()->subMonth();
                        $next = $current->copy()->addMonth();
                    @endphp
                    <a href="{{ route('calendar.show', ['date' => $prev->format('Y-m-d')]) }}"
                       class="text-blue-600 hover:underline">← {{ $prev->format('F Y') }}</a>
                    <h2 class="text-2xl font-semibold text-gray-800">{{ $current->format('F Y') }}</h2>
                    <a href="{{ route('calendar.show', ['date' => $next->format('Y-m-d')]) }}"
                       class="text-blue-600 hover:underline">{{ $next->format('F Y') }} →</a>
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

                    @php
                        $startOfMonth = \Carbon\Carbon::create($year, $month, 1);
                        $endOfMonth = $startOfMonth->copy()->endOfMonth();
                        $startDayOfWeek = $startOfMonth->dayOfWeek; // 0 (Sun) to 6 (Sat)
                        $daysInMonth = $startOfMonth->daysInMonth;
                    @endphp

                    <!-- Weeks -->
                    <div class="grid grid-cols-7 gap-2">
                        <!-- Empty cells before the first day -->
                        @for ($i = 0; $i < $startDayOfWeek; $i++)
                            <div></div>
                        @endfor

                        <!-- Days of the month -->
                        @for ($day = 1; $day <= $daysInMonth; $day++)
                            <div class="calendar-cell">
                                <span class="date-number">{{ $day }}</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
@endsection