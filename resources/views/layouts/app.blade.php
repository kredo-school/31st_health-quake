<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Health Quake') }}</title>

    <!-- Tailwind CSS -->
    @vite('resources/css/app.css') 
    @yield('css') 
    <!-- カスタムスタイル -->
    <link rel="stylesheet" href="/css/register.css">
    
    <!-- ナビゲーションバー -->
    <nav class="bg-white shadow-md p-4 flex justify-between items-center">
        <!-- 左側：ロゴとアプリ名 -->
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/IMG_2624.png') }}" alt="Health Quake Logo" class="h-8">
            <img src="{{ asset('images/IMG_2625.png') }}" alt="Health Quake Logo" class="h-6">
            
        </div>
    
        <!-- 中央：リンク -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800">Home</a>
            <a href="{{ route('calendar') }}" class="text-gray-600 hover:text-gray-800">Calendar</a>
            <a href="{{ route('ranking') }}" class="text-gray-600 hover:text-gray-800">Ranking</a>
        </div>
    
       <!-- 右側：ユーザーアイコン -->
<div class="relative">
    @if (auth()->check())
        {{-- ログイン中の場合 --}}
        <span class="sr-only">ユーザーメニューを開く</span>
        <img class="rounded-full" src="{{ auth()->user()->profile_photo_url ?? asset('images/default-user-icon.png') }}" alt="{{ auth()->user()->name }}">
        <!-- ログアウトリンク -->
                    <!-- フォームを使用してログアウト処理を実行 -->
                    <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-gray-800">Logout</button>
                    </form>
    
        @else
        {{-- ログインしていない場合 --}}
        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800">Log in</a>
        &nbsp;|&nbsp;
        <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-800">Register</a>
    @endif
</div>
    </nav>
</head>
<body class="bg-teal font-sans antialiased h-screen flex items-center justify-center">

    <!-- メインコンテンツ -->
    <div class="container mx-auto px-4 text-center">
        <!-- ヘッダー（ロゴ） -->
        {{-- <header class="mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="Health Quake" class="logo mx-auto">
        </header> --}}

        <!-- ページコンテンツ -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- スクリプト -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>