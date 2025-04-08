@extends('layouts.app')

@section('content')
<!-- resources/views/routines/SetRoutine.blade.php -->

@if(session('success'))
    <div class="bg-green-100 text-green-800 p-4 mb-4 rounded">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-800 p-4 mb-4 rounded">
        {{ session('error') }}
    </div>
@endif

<div class="container mx-auto px-4 pt-auto">
    <!-- 日付選択 -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold mb-4 text-center">December, 2025</h3>
        <div class="grid grid-cols-7 gap-2 justify-items-center">
            @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                <div class="text-gray-500 text-xs">{{ $day }}</div> <!-- 曜日表示 -->
            @endforeach
            @for($i = 1; $i <= 7; $i++)
                <div class="p-2 rounded w-16 h-16 flex flex-col items-center justify-center {{ $i == 9 ? 'bg-blue-500 text-white' : 'bg-gray-100' }}">
                    <span class="text-sm">{{ $i }}</span> <!-- 日付数字 -->
                    @if($i == 3)
                        <div class="w-4 h-4 bg-green-500 rounded-full mt-1"></div> <!-- アクティブな日付のマーク -->
                    @endif
                </div>
            @endfor
        </div>
    </div>

    <!-- Add Habit ボタン -->
    <a href="{{ route('add_habit') }}" 
       class="inline-block mb-6 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-200 mx-auto block"
    >
        Add habits
    </a>

    <h1 class="text-3xl font-bold mb-6 text-center">List Habits</h1> <!-- 見出し -->

    <!-- 習慣一覧 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
        @foreach($habits as $habit)
            <div class="bg-white p-4 rounded-lg shadow-md max-w-sm mx-auto">
                <div class="flex justify-between items-start">
                    <!-- 左側：習慣の詳細 -->
                    <div>
                        <p class="text-lg font-semibold">{{ $habit->name }}</p> <!-- 習慣名 -->
                        <p class="text-sm text-gray-500">{{ $habit->category }} | {{ $habit->date }}</p> <!-- カテゴリと日付 -->
                    </div>
                    <!-- 右側：削除ボタンと START ボタン -->
                    <div class="flex flex-col items-end space-y-2">
                        <div class="flex space-x-2">
                            <!-- 削除ボタン -->
                            <a href="{{ route('delete-habit', ['id' => $habit->id]) }}" 
                               class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition"
                            >
                                Delete
                            </a>
                            <!-- START ボタン -->
                                <a href="/timer/start?duration={{ $habit->duration }}"
                                    class="px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition">
                                    START
                                </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection