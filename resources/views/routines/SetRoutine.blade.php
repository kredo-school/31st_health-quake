@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 pt-24">
    <!-- 日付選択 -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold mb-4 text-center">December, 2025</h3>
        <div class="grid grid-cols-7 gap-2 justify-items-center">
            @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
                <div class="text-gray-500 text-xs mb-1">{{ $day }}</div>
            @endforeach
            @for($i = 1; $i <= 7; $i++)
                <div class="p-2 rounded w-16 h-16 flex flex-col items-center justify-center">
                    <span class="text-sm">{{ $i }}</span>
                    @if($i == 3)
                        <div class="w-4 h-4 bg-green-500 rounded-full mt-1"></div>
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

    <h1 class="text-3xl font-bold mb-6 text-center">List Habits</h1>

    <!-- 習慣一覧 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
        @foreach($habits as $habit)
        <div class="bg-white p-4 rounded-lg shadow-md max-w-sm mx-auto">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <p class="text-lg font-semibold">{{ $habit->name }}</p>
                    <p class="text-sm text-gray-500">{{ $habit->category }} {{ $habit->date }}</p>
                </div>
    <!-- 削除ボタンの安全設計 -->
                <button type="button" 
                        class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition"
                        onclick="confirmDelete({{ $habit->id }})"
                >Delete</button>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection