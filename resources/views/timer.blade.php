<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Timer Page</title>
    @vite('resources/css/app.css') {{-- Tailwind を読み込み --}}

    {{-- タイマー動作中のみ自動リロード --}}
    @if(session('is_timer_running'))
        <meta http-equiv="refresh" content="1;url={{ route('timer.show') }}">
    @endif
</head>
<body class="bg-blue-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow text-center w-full max-w-md">
        <!-- ヘッダー情報 -->
        <h1 class="text-2xl font-bold mb-4">
            {{ $habitName }}, {{ $category }}, {{ $date ?? 'No Date' }}
        </h1>

        <!-- タイマー表示 -->
        <div class="text-5xl font-semibold mb-2">
            {{ $timeCount }}
        </div>
        <p class="text-gray-600">Time elapsed since start</p>

        <!-- DONE ボタン -->
        <div class="mt-6">
            <form action="{{ route('timer.done') }}" method="POST">
                @csrf
                <input type="hidden" name="name" value="{{ $habitName }}">
                <input type="hidden" name="category" value="{{ $category }}">
                <button type="submit"
                        class="bg-green-500 text-white px-8 py-3 rounded font-bold hover:bg-green-600 transition">
                    DONE
                </button>
            </form>
        </div>

        <!-- STOP / RESTART / QUIT -->
        <div class="mt-4 flex justify-center space-x-4">
            @if(session('is_timer_running'))
                <form action="{{ route('timer.stop') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="bg-orange-500 text-white px-6 py-3 rounded font-bold hover:bg-orange-600 transition">
                        Stop
                    </button>
                </form>
            @else
                <form action="{{ route('timer.restart') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="bg-blue-500 text-white px-6 py-3 rounded font-bold hover:bg-blue-600 transition">
                        Restart
                    </button>
                </form>
            @endif

            <form action="{{ route('set-routine.quit') }}" method="POST">
                @csrf
                <button class="bg-purple-500 text-white px-6 py-3 rounded font-bold hover:bg-purple-600 transition">
                    Quit Tasks
                </button>
            </form>
        </div>
    </div>
</body>
</html>
