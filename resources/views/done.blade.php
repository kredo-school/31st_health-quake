@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Task Complete - Health Quake</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #E0F7FA;
            overflow: auto;
        }
        .timer-display {
            font-family: 'Courier New', monospace;
            font-size: 3rem;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">
                    {{ $habit->name }}, {{ $habit->category }},
                    <br>
                    {{ \Carbon\Carbon::parse($habit->date)->format('Y-m-d H:i:s') }}
                </h2>
            </div>

            <div class="timer-display text-center mb-8">
                <span id="timer">4:00</span>
                <div class="text-sm text-gray-500">経過時間</div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <button id="done-button"
                        data-habit-id="{{ $habit->id }}"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline">
                    DONE
                </button>

                <div class="grid grid-cols-2 gap-4">
                    <button id="stop-button"
                            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline">
                        Stop
                    </button>
                    <button id="quit-button"
                            class="w-full bg-purple-500 hover:bg-purple-600 text-white font-bold py-3 px-4 rounded focus:outline-none focus:shadow-outline">
                        Quit Tasks
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // CSRF トークンを取得
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // DONEボタンのイベントハンドラ
        document.getElementById('done-button').addEventListener('click', function() {
            const habitId = this.dataset.habitId;

            // 完了APIを呼び出す
            fetch(`/habits/${habitId}/complete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // リダイレクト先のURLに移動
                    window.location.href = data.redirectUrl;
                } else {
                    alert(data.message || 'エラーが発生しました');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('習慣の完了中にエラーが発生しました');
            });
        });

        // Stopボタンのイベントハンドラ
        document.getElementById('stop-button').addEventListener('click', function() {
            // タイマーを停止する処理
            fetch('/timer/stop', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                location.reload(); // ページを再読み込み
            })
            .catch(error => {
                console.error('Error:', error);
                alert('タイマーの停止中にエラーが発生しました');
            });
        });

        // Quitボタンのイベントハンドラ
        document.getElementById('quit-button').addEventListener('click', function() {
            if (confirm('タスクを終了しますか？進行状況は保存されません。')) {
                // タスクを終了する処理
                window.location.href = '{{ route("calendar.index") }}';
            }
        });
    </script>
</body>
</html>
@endsection
