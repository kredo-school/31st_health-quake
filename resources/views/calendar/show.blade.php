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
            margin-top: 420px;
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
            top: 2px;
            left: 4px;
            font-size: 0.75rem;
            font-weight: 500;
            z-index: 10;
        }
        .habit-square {
            width: 100%;
            height: 6px;
            margin-top: 2px;
            border-radius: 2px;
        }
        .category-header {
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
<<<<<<< HEAD
        .exercise { border-color: #EF4444; }
        .nutrition { border-color: #36DB96; }
        .sleep { border-color: #3B82F6; }
        .other { border-color: #A855F7; }

=======
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
>>>>>>> Makoto_2
    </style>
</head>
<body>
    <main class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <div class="md:col-span-1">
                <div class="for-example">for example:</div>
                <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                    <div class="category-header bg-red-400 text-white">Exercise</div>
                        <div class="category-item exercise">🏃‍♂️ Running</div>
                    <div class="category-item exercise">💪 Strength Training</div>
                    <div class="category-item exercise">🧘 Yoga</div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                    <div class="category-header bg-green-400 text-white">Nutrition</div>
                    <div class="category-item nutrition">🥗 Healthy Meal</div>
                    <div class="category-item nutrition">💧 Water Intake</div>
                    <div class="category-item nutrition">🍫 No Snacks</div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                    <div class="category-header bg-blue-400 text-white">Sleep</div>
                    <div class="category-item sleep">🛌 Early to Bed</div>
                    <div class="category-item sleep">💤 8+ Hours</div>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="category-header bg-purple-400 text-white">Other</div>
                    <div class="category-item other">📚 Reading</div>
                    <div class="category-item other">🧠 Meditation</div>
                </div>
            </div>
            <section class="bg-white rounded-lg shadow-sm p-6 mb-8 md:col-span-4">
                <div class="flex space-x-4 mb-8">
                    <div class="flex items-center"><div class="habit-icon bg-red-400 mr-1"></div><span class="text-sm">Exercise</span></div>
                    <div class="flex items-center"><div class="habit-icon bg-green-400 mr-1"></div><span class="text-sm">Nutrition</span></div>
                    <div class="flex items-center"><div class="habit-icon bg-blue-400 mr-1"></div><span class="text-sm">Sleep</span></div>
                    <div class="flex items-center"><div class="habit-icon bg-purple-400 mr-1"></div><span class="text-sm">Other</span></div>
                </div>
                <div class="flex justify-between items-center mb-6">
                    @php
                        use Carbon\Carbon;
                        $current = Carbon::create($year ?? now()->year, $month ?? now()->month, 1);
                        $prev = $current->copy()->subMonth();
                        $next = $current->copy()->addMonth();
                    @endphp
                    <a href="{{ route('calendar.show', ['date' => $prev->format('Y-m-d')]) }}" class="text-blue-600 hover:underline">← {{ $prev->format('F Y') }}</a>
                    <h2 class="text-2xl font-semibold text-gray-800">{{ $current->format('F Y') }}</h2>
                    <a href="{{ route('calendar.show', ['date' => $next->format('Y-m-d')]) }}" class="text-blue-600 hover:underline">{{ $next->format('F Y') }} →</a>
                </div>
<<<<<<< HEAD
                <div class="grid grid-cols-7 gap-2 mb-2 text-center text-sm text-gray-500">
                    <div>SUN</div><div>MON</div><div>TUE</div><div>WED</div><div>THU</div><div>FRI</div><div>SAT</div>
                </div>
                <div class="grid grid-cols-7 gap-2">
=======

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

>>>>>>> Makoto_2
                    @php
                        $startOfMonth = \Carbon\Carbon::create($year, $month, 1);
                        $endOfMonth = $startOfMonth->copy()->endOfMonth();
                        $startDayOfWeek = $startOfMonth->dayOfWeek; // 0 (Sun) to 6 (Sat)
                        $daysInMonth = $startOfMonth->daysInMonth;
                    @endphp
<<<<<<< HEAD
                    @for ($i = 0; $i < $totalCells; $i++)
                    @if ($i < $startDayOfWeek || $dayCounter > $daysInMonth)
                        <div class="calendar-cell bg-gray-100"></div>
                    @else
                        @php
                            $dateStr = Carbon::create($year, $month, $dayCounter)->format('Y-m-d');
                            // $habits = $markedHabits[$dateStr] ?? [];
                            $notes = $descriptions[$dateStr] ?? [];
                            $habit_name = null;
                            // echo $dateStr;
                                foreach ($habits as $habit) {
                                    $date = \Carbon\Carbon::parse($habit['date'])->format('Y-m-d');
                                    if ($date === $dateStr) {
                                        $habit_name= $habit['name'];
                                        break;
                                    }
                                }
                        @endphp
                        <div class="calendar-cell bg-white">
                                {{$dayCounter}}<br>{{ $habit_name }}
                                 <!-- Habit category color bars -->
                                 <div class="habit-square {{ $habits['exercise'] ?? false ? 'bg-red-400' : '' }}"></div>
                                 <div class="habit-square {{ $habits['nutrition'] ?? false ? 'bg-green-400' : '' }}"></div>
                                 <div class="habit-square {{ $habits['sleep'] ?? false ? 'bg-blue-400' : '' }}"></div>
                                 <div class="habit-square {{ $habits['other'] ?? false ? 'bg-purple-400' : '' }}"></div>
                                
                                {{-- Descriptions --}}
                                @if (!empty($descriptions[$dateStr]))
                                    <div class="mt-1 text-xs space-y-1 overflow-y-auto max-h-16">
                                        @foreach ($descriptions[$dateStr] as $desc)
                                            <div class="px-1 py-0.5 rounded" style="background-color: {{ $desc['color'] }};">
                                                {{ $desc['text'] }}
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
=======

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
>>>>>>> Makoto_2
                            </div>
                        @php $dayCounter++; @endphp
                    @endif
                @endfor
                </div>
            </section>
        </div>
    </main>
</body>
</html>
@endsection
