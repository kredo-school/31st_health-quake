<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Health Quake') }}</title>

    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/register.css">
    @yield('css')
    @yield('styles')
</head>
<body>
    <!-- ナビゲーションバー - 修正版 -->
    <div class="nav-container">
        <nav class="bg-white shadow-md">
            <div class="container mx-auto flex justify-between items-center py-2">
                <!-- 左端：ロゴ -->
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('images/IMG_2624.png') }}" alt="Health Quake Logo" class="h-8 max-h-full object-contain">
                    <img src="{{ asset('images/IMG_2625.png') }}" alt="Health Quake Logo" class="h-8 max-h-full object-contain">
                </div>

                <!-- 中央：リンク -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800">Home</a>
                    <a href="{{ route('calendar.calendarnew') }}" class="text-gray-600 hover:text-gray-800">Calendar</a>
                    <a href="{{ route('set-routine') }}" class="text-gray-600 hover:text-gray-800">Task</a>
                    <a href="{{ route('ranking') }}" class="text-gray-600 hover:text-gray-800">Ranking</a>
                </div>

                <!-- 右端：ユーザーアイコン -->
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
    </div>

    <!-- メインコンテンツ -->
    <div class="content-container">
        @yield('content')
    </div>
</body>
</html>
