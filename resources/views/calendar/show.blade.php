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
        /* スタイルはそのままで問題ありません */
        body {
            font-family: Arial, sans-serif;
            background-color: #E0F7FA;
            padding-top: 60px;
            overflow: auto;
        }
        main {
            margin-top: 320px;
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
        .exercise { border-color: #EF4444; }
        .nutrition { border-color: #36DB96; }
        .sleep { border-color: #3B82F6; }
        .other { border-color: #A855F7; }
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
                        $startOfMonth = Carbon::create($year, $month, 1);
                        $startDayOfWeek = $startOfMonth->dayOfWeek;
                        $daysInMonth = $startOfMonth->daysInMonth;
                    @endphp
                    <a href="{{ route('calendar.show', ['date' => $prev->format('Y-m-d')]) }}" class="text-blue-600 hover:underline">← {{ $prev->format('F Y') }}</a>
                    <h2 class="text-2xl font-semibold text-gray-800">{{ $current->format('F Y') }}</h2>
                    <a href="{{ route('calendar.show', ['date' => $next->format('Y-m-d')]) }}" class="text-blue-600 hover:underline">{{ $next->format('F Y') }} →</a>
                </div>
                <div class="grid grid-cols-7 gap-2 mb-2 text-center text-sm text-gray-500">
                    <div>SUN</div><div>MON</div><div>TUE</div><div>WED</div><div>THU</div><div>FRI</div><div>SAT</div>
                </div>
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
                                $dateStr = Carbon::create($year, $month, $dayCounter)->format('Y-m-d');
                                $isToday = $dateStr === $today;
                            @endphp
                            <div class="calendar-cell {{ $isToday ? 'bg-blue-50 border-blue-400 border-2' : 'bg-white' }}">
                                <span class="date-number {{ $isToday ? 'font-bold text-blue-600' : '' }}">{{$dayCounter}}</span>

                                {{-- 日付に関連する習慣を表示（descriptions配列から） --}}
                                @if (isset($descriptions[$dateStr]) && count($descriptions[$dateStr]) > 0)
                                    <div class="mt-5 text-xs space-y-1 overflow-y-auto max-h-16">
                                        @foreach ($descriptions[$dateStr] as $habit)
                                            <div class="px-1 py-0.5 rounded text-white {{ $habit['color'] }}"
                                                 title="{{ $habit['text'] }}">
                                                {{ $habit['text'] }}
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            @php $dayCounter++; @endphp
                        @endif
                    @endfor
                </div>

                {{-- ここからデバッグ情報部分を削除します --}}
                {{--
                <div class="mt-8 p-4 bg-gray-100 rounded text-xs">
                    <h3 class="font-bold mb-2">デバッグ情報</h3>
                    <p>Habits テーブルからの習慣数: {{ count($habits ?? []) }}</p>
                    <p>CompletedHabits テーブルからの習慣数: {{ count($completedHabits ?? []) }}</p>
                    <p>descriptions 配列のエントリー数: {{ count($descriptions ?? []) }}</p>

                    @if(count($completedHabits ?? []) > 0)
                        <h4 class="font-bold mt-2">CompletedHabits データ：</h4>
                        <ul class="list-disc pl-5">
                            @foreach($completedHabits as $habit)
                                <li>{{ $habit->name }} ({{ $habit->category }}) - {{ $habit->completed_date->format('Y-m-d') }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                --}}
            </section>
        </div>
    </main>
</body>
</html>
@endsection
