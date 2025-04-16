<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Health Quake') }}</title>

    <!-- Tailwind CSS -->
    @vite('resources/css/app.css') 
    @yield('css') 
</head>
<body class="bg-teal font-sans antialiased">

    <!-- 固定ナビゲーションバー -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <!-- 左端：ロゴ -->
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/IMG_2624.png') }}" alt="Health Quake Logo" class="h-8 max-h-full object-contain">
                <img src="{{ asset('images/IMG_2625.png') }}" alt="Health Quake Logo" class="h-8 max-h-full object-contain">
            </div>

            <!-- 中央：リンク -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800">Home</a>
                @php
                    $currentDate = \Carbon\Carbon::now()->format('Y-m-d'); // 現在の日付をデフォルト値として使用
                @endphp
                <a href="{{ route('calendar.show', ['date' => $currentDate]) }}">Calendar</a>
                <a href="{{ route('set-routine') }}" class="text-gray-600 hover:text-gray-800">Task</a>
                <a href="{{ route('ranking') }}" class="text-gray-600 hover:text-gray-800">Ranking</a>
            </div>

          <!-- 右端：ユーザーエリア -->
            <div class="flexitems-center space-x-4">
                @if (auth()->check())
                    <!-- プロフィールアイコン（DBに保存された画像を表示） -->
                    <a href="{{ route('profile') }}">
                        <img class="h-10 w-10 rounded-full border-2 object-cover"
                            src="{{ auth()->user()->profile_photo_url }}"
                            alt="{{ auth()->user()->name }}">

                    <!-- ログアウトボタン -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-white-600 hover:text-gray-400">
                            Log out
                        </button>
                    </form>
                @else
                    <!-- ログイン・登録リンク（未ログイン時） -->
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800">Log in</a>
                    <span class="text-gray-400">|</span>
                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-800">Register</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- メインコンテンツ -->
    <div class="container mx-auto px-4" style="padding-top: calc(6rem + 16px);">
        <main>
            @yield('content')
            {{-- 登録ページ : resources/views/auth/register.blade.php --}}
            {{-- ログインページ : resources/views/auth/login.blade.php --}}
        </main>
    </div>

    <!-- カスタムスタイル（必要に応じて） -->
    <link rel="stylesheet" href="/css/register.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @yield('styles')
</body>
</html>
