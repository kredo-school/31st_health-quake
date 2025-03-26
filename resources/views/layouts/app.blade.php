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
</head>
<body class="bg-teal font-sans antialiased h-screen flex items-center justify-center">

     <!-- ナビゲーションバー -->
     <nav class="bg-white shadow-md p-4 flex justify-between items-center">
        <!-- 左側：ロゴとアプリ名 -->
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logo.png') }}" alt="Health Quake Logo" class="h-8">
            <div>
                <span class="text-xl font-bold">Health</span>
                <span class="text-xl font-bold">Quake</span>
            </div>
        </div>
    
        <!-- 中央：リンク -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800">Home</a>
            <a href="{{ route('calendar') }}" class="text-gray-600 hover:text-gray-800">Calendar</a>
            <a href="{{ route('ranking') }}" class="text-gray-600 hover:text-gray-800">Ranking</a>
        </div>
    
        <!-- 右側：ユーザーアイコン -->
        <div class="relative">
            <button id="user-menu-button" type="button" class="flex text-sm bg-gray-800 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                <span class="sr-only">ユーザーメニューを開く</span>
                <img class="h-8 w-8 rounded-full" src="{{ auth()->user()->profile_photo_url ?? asset('images/default-user-icon.png') }}" alt="{{ auth()->user()->name }}">
            </button>
        </div>
    </nav>
    
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