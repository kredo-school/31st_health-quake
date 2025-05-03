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

        /* 削除ボタンのスタイル強化 */
        .delete-btn {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            line-height: 14px;
            text-align: center;
            font-weight: bold;
            cursor: pointer;
            display: inline-block;
            margin-left: 4px;
        }
        .delete-btn:hover {
            background-color: rgba(255, 0, 0, 0.6);
        }
    </style>
</head>
<body>
    <!-- デバッグ情報 -->
    <div style="background: #f0f0f0; padding: 10px; margin: 10px; position: fixed; top: 0; right: 0; z-index: 1000; max-height: 300px; overflow: auto; font-size: 12px;">
        <h3>デバッグ情報</h3>
        <p>descriptions配列のキー:</p>
        <ul>
            @foreach($descriptions as $date => $habits)
                <li>{{ $date }} - {{ count($habits) }}件の習慣</li>
                <ul>
                    @foreach($habits as $habit)
                        <li>ID: {{ $habit['habit_id'] ?? 'なし' }} - {{ $habit['text'] }}</li>
                    @endforeach
                </ul>
            @endforeach
        </ul>
    </div>

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
                <!-- 成功・エラーメッセージの表示 -->
                @if (session('success'))
                    <div class="alert alert-success bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                        {{ session('error') }}
                    </div>
                @endif

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

                                // $descriptionsから日付ごとの習慣を取得
                                $dayHabits = isset($descriptions[$dateStr]) ? $descriptions[$dateStr] : [];
                            @endphp
                            <div class="calendar-cell bg-white">
                                <span class="date-number">{{$dayCounter}}</span>

                                {{-- 日付に関連する習慣を直接表示 --}}
                                @if (count($dayHabits) > 0)
                                    <div class="mt-5 text-xs space-y-1 overflow-y-auto max-h-16">
                                        @foreach ($dayHabits as $habit)
                                            <div class="px-1 py-0.5 rounded text-white {{ $habit['color'] }} flex justify-between items-center">
                                                <span>{{ $habit['text'] }}</span>
                                                <a href="#" onclick="if(confirm('本当に削除しますか？')) { document.getElementById('delete-form-{{ $habit['habit_id'] }}').submit(); } return false;" class="delete-btn">×</a>
                                            </div>
                                            <form id="delete-form-{{ $habit['habit_id'] }}" action="{{ route('calendar.delete-habit', ['id' => $habit['habit_id']]) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            @php $dayCounter++; @endphp
                        @endif
                    @endfor
                </div>
            </section>
        </div>
    </main>

    <!-- JavaScriptを追加 -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('ページが読み込まれました。削除機能を初期化します。');

        // フォームの送信をログに記録
        const deleteForms = document.querySelectorAll('form[action*="calendar.delete-habit"]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                console.log('削除フォームが送信されました：', this.action);
                // ここではデフォルトの動作を止めず、通常通り送信させます
            });
        });
    });
    </script>
</body>
</html>
@endsection
