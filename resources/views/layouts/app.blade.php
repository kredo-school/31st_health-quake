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
                <a href="{{ route('calendar.index') }}" class="text-gray-600 hover:text-gray-800">Calendar</a>
                <a href="{{ route('set-routine') }}" class="text-gray-600 hover:text-gray-800">Task</a>
                <a href="{{ route('ranking') }}" class="text-gray-600 hover:text-gray-800">Ranking</a>
            </div>

            <!-- 右端：ユーザーアイコン -->
            {{-- のちほど調整すべき点：ユーザーアイコンがデフォルト画像に指定→ユーザーuniqueに変更、logoutやアイコン画像の変更機能について配置を再検討 --}}
            {{-- <img class="rounded-full" src="{{ auth()->user()->profile_photo_url ?? asset('images/default-user-icon.png') }}" alt="{{ auth()->user()->name }}"> --}}
            <div class="relative">
                @if (auth()->check())
                
                <img src="{{ asset('images/default-user-icon.png') }}" class="h-8 max-h-full object-contain">
                    |&nbsp;
                    <a href="{{ route('logout') }}" class="text-gray-600 hover:text-gray-800">Log out</a>
                    &nbsp;|
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800">Log in</a>
                    &nbsp;|&nbsp;
                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-gray-800">Register</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- メインコンテンツ -->
<div class="container mx-auto px-4" style="padding-top: calc(6rem + 16px);">
    <main>
        @yield('content')
        {{--　 登録ページ : resources/views/auth/register.blade.php
        　　ログインページ : resources/views/auth/login.blade.php --}}
    </main>
</div>
</body>

    <!-- カスタムスタイル（必要に応じて） -->
    <link rel="stylesheet" href="/css/register.css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    @yield('styles')
</html>