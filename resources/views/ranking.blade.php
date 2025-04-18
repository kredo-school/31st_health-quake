@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100 m-0 p-0 font-sans">
    
    <!-- Main contents -->
    <main class="max-w-3xl mx-auto p-5">
        @foreach ($ranks as $rank)
            <div class="flex items-center bg-white rounded-lg shadow-md p-4 mb-4">
                <img src="{{ $rank['avatar'] }}" alt="{{ $rank['name'] }}" class="w-12 h-12 rounded-full object-cover mr-4">
                <div>
                    <span class="text-xl font-bold text-gray-800 mr-2">#{{ $rank['position'] }}</span>
                    <span class="text-lg font-bold text-gray-800">{{ $rank['name'] }}</span>
                </div>
                <span class="text-sm text-gray-600 ml-auto">{{ $rank['points'] }} points</span>
                @if ($loop->iteration === 4)
                    <!-- Mark the fourth element as an example -->
                    <div class="relative ml-5 -mt-5">
                        <span class="text-sm text-gray-600 ml-3">You are here</span>
                        <div class="absolute top-1/2 left-[-20px] transform -translate-y-1/2 w-0 h-0 border-solid border-l-8 border-t-8 border-b-8 border-transparent border-t-yellow-500"></div>
                    </div>
                @endif
            </div>
        @endforeach
    </main>
</body>
</html>
@endsection




















