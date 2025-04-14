<!-- resources/views/timer.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Timer Page</title>
    @vite('resources/css/app.css') {{-- Tailwindを読み込む --}}
    <!-- 自動リロードの設定 -->
    @if(session('is_timer_running'))
        <meta http-equiv="refresh" content="1;url={{ route('timer.show') }}">
    @endif
</head>
<body class="bg-blue-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow text-center">
        <!-- 上部のテキスト (例: Running, Exercise Category, 2025-03-14) -->
        <h1 class="text-2xl font-bold">
            {{ $habitName }}, {{ $category }}, {{ $date ?? 'No Date' }}
        </h1>

        <!-- タイマー部分 -->
        <div class="text-4xl font-semibold mt-4">{{ $timeCount }}</div>
        <p class="text-gray-600">Time counted from start</p>

        <!-- DONEボタン -->
        <div class="mt-6">
            <form action="{{ route('timer.done') }}" method="POST">
                @csrf
                <button type="submit"
                        class="bg-green-500 text-white px-8 py-3 rounded font-bold hover:bg-green-600 transition">
                    DONE
                </button>
            </form>
        </div>

        <!-- Stop / Restart / Quit Tasks ボタン -->
        <div class="mt-4 flex justify-center space-x-4">
            <!-- Stop ボタン -->
            @if(session('is_timer_running'))
                <form action="{{ route('timer.stop') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="bg-orange-500 text-white px-6 py-3 rounded font-bold hover:bg-orange-600 transition">
                        Stop
                    </button>
                </form>
            @else
                <!-- Restart ボタン -->
                <form action="{{ route('timer.restart') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="bg-blue-500 text-white px-6 py-3 rounded font-bold hover:bg-blue-600 transition">
                        Restart
                    </button>
                </form>
            @endif

            <!-- Quit Tasks ボタン -->
            <form action="{{ route('set-routine.quit') }}" method="POST" class="inline">
                @csrf
                <button
                    class="bg-purple-500 text-white px-6 py-3 rounded font-bold hover:bg-purple-600 transition">
                    Quit Tasks
                </button>
            </form>
        </div>
    </div>
</body>
</html>