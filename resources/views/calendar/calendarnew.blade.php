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
            padding-top: 60px;
            overflow: auto;
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
            padding: 4px;
            overflow-y: auto;
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
            background-color: #0066CC;
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
        .exercise { border-color: #EF4444; } 
        .nutrition { border-color: #84CC16; }
        .sleep { border-color: #3B82F6; }
        .other { border-color: #A855F7; }
    </style>
</head>
<body>
<main class="container mx-auto px-4 py-6">
    @php
    use Carbon\Carbon; // Carbonをインポート
    $year = $year ?? now()->year; // 未定義の場合、現在の年を使用
    $month = $month ?? now()->month; // 未定義の場合、現在の月を使用
    $startDayOfWeek = $startDayOfWeek ?? Carbon::create($year, $month, 1)->dayOfWeek;
    $daysInMonth = $daysInMonth ?? Carbon::create($year, $month, 1)->daysInMonth;
    $markedHabits = $markedHabits ?? [];
@endphp
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <!-- Left Panel (Examples) -->
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
                    $current = \Carbon\Carbon::create($year, $month, 1);
                    $prev = $current->copy()->subMonth();
                    $next = $current->copy()->addMonth();
                @endphp
                <a href="{{ route('calendar.shownew', ['month' => $prev->month, 'year' => $prev->year]) }}"
                   class="text-blue-600 hover:underline">← {{ $prev->format('F Y') }}</a>
                <h2 class="text-2xl font-semibold text-gray-800">{{ $current->format('F Y') }}</h2>
                <a href="{{ route('calendar.shownew', ['month' => $next->month, 'year' => $next->year]) }}"
                   class="text-blue-600 hover:underline">{{ $next->format('F Y') }} →</a>
            </div>
            <!-- Weekday Headings -->
            <div class="grid grid-cols-7 gap-2 text-center text-gray-600 font-semibold mb-2">
                <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
            </div>
            <!-- Calendar Grid -->
            <div class="grid grid-cols-7 gap-2">
                @php
                    $dayCounter = 1;
                    $totalCells = ceil(($startDayOfWeek + $daysInMonth) / 7) * 7;
                @endphp
                @for ($i = 0; $i < $totalCells; $i++)
                    @if ($i < $startDayOfWeek || $dayCounter > $daysInMonth)
                        <div class="calendar-cell bg-gray-100"></div>
                    @else
                        @php
                            $dateStr = \Carbon\Carbon::create($year, $month, $dayCounter)->format('Y-m-d');
                            $habits = $markedHabits[$dateStr] ?? [];
                            // $notes = $descriptions[$dateStr] ?? [];
                        @endphp
                        <div class="calendar-cell bg-white">
                            <span class="date-number">{{ $dayCounter }}</span>
                            <div class="habit-square {{ $habits['exercise'] ?? false ? 'bg-red-400' : '' }}"></div>
                            <div class="habit-square {{ $habits['nutrition'] ?? false ? 'bg-green-400' : '' }}"></div>
                            <div class="habit-square {{ $habits['sleep'] ?? false ? 'bg-blue-400' : '' }}"></div>
                            <div class="habit-square {{ $habits['other'] ?? false ? 'bg-purple-400' : '' }}"></div>
                            {{-- @foreach ($notes as $note)
                                <div class="mt-1 text-xs text-gray-800 px-1 py-1 rounded {{ $note['color'] }}">
                                    {{ $note['text'] }}
                                </div>
                            @endforeach --}}
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