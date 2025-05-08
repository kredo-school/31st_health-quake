@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center">
    <!-- ペナルティのアイコンとテキスト -->
    <div class="flex flex-col items-center mb-8">
        <img src="{{ asset('images/level_down.png') }}" alt="Level Down Arrow" class="w-auto h-32 mb-4">
        {{-- <p class="text-2xl font-bold text-gray-700 mb-2">You have been penalized!</p> --}}
        <p class="text-lg text-gray-600">Due to inactivity, your level has been decreased.</p>
        <p class="text-lg text-gray-600">Please log in daily to maintain your level.</p>
        {{-- <h1 class="text-5xl font-bold text-red-600">LEVEL DOWN</h1> --}}
    </div>

    <!-- ペナルティの詳細情報 -->
    <div class="bg-white rounded-lg shadow-md p-8 w-full max-w-md text-center">
        <p class="text-xl text-gray-700 mb-4">
            CONSECUTIVE DAYS WITHOUT LOGGING IN :
            <span class="font-bold text-2xl">{{ $consecutiveDays }}</span> DAYS
        </p>

        <div class="mb-4">
            <p class="text-lg font-bold text-gray-700">
                PREVIOUS YOUR LEVEL : 
                <span class="font-bold text-2xl">{{ $previousLevel }}</span>
            </p>
        </div>

        <div>
            <p class="text-lg font-bold text-gray-700">
                NOW YOUR LEVEL : 
                <span class="font-bold text-2xl">{{ $currentLevel }}</span>
                <span class="text-indigo-600 ml-2">↓ DOWN</span>
            </p>
        </div>

        <!-- 続行ボタン -->
        <div class="mt-8">
            <a href="{{ route('calendar.show', ['date' => now()->format('Y-m-d')]) }}"
               class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                Continue to Calendar
            </a>
        </div>
    </div>
</div>
@endsection