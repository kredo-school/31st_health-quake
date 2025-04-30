<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - {{ config('app.name', 'Health Quake') }}</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 font-sans h-screen overflow-hidden">
    <!-- ナビゲーションバー -->
    <nav class="bg-white shadow-md fixed top-0 w-full z-50">
        <div class="container mx-auto flex justify-between items-center py-2">
            <!-- 左端：ロゴ -->
            <div class="flex items-center space-x-2">
                <img src="{{ asset('images/IMG_2624.png') }}" alt="Health Quake Logo" class="h-8 object-contain">
                <img src="{{ asset('images/IMG_2625.png') }}" alt="Health Quake Logo" class="h-8 object-contain">
            </div>

            <!-- 中央：リンク -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800">Home</a>
                @php
                    $currentDate = \Carbon\Carbon::now()->format('Y-m-d');
                @endphp
                <a href="{{ route('calendar.show', ['date' => $currentDate]) }}" class="text-gray-600 hover:text-gray-800">Calendar</a>
                <a href="{{ route('set-routine') }}" class="text-gray-600 hover:text-gray-800">Task</a>
                <a href="{{ route('ranking') }}" class="text-gray-600 hover:text-gray-800">Ranking</a>
            </div>

            <!-- 右端：ユーザーエリア -->
            <div class="flex items-center space-x-4">
                @if (auth()->check())
                    <!-- プロフィールアイコン（DBに保存された画像を表示） -->
                    <a href="{{ route('profile') }}">
                        <img class="h-10 w-10 rounded-full border-2 object-cover"
                            src="{{ asset(auth()->user()->profile_photo_url) }}"
                            alt="{{ auth()->user()->name }}">
                    </a>

                    <!-- ログアウトボタン -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-800">
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

    <!-- 本体：サイドバー＋メイン -->
    <div class="flex h-[calc(100vh-64px)] overflow-hidden mt-14">
       
        <!-- メインコンテンツ -->
        <main class="flex-1 overflow-y-auto p-6 ml-64">
            @yield('content')
        </main>
    </div>
</body>
</html>