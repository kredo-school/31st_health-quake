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

@php
    use Carbon\Carbon;

    $today = Carbon::today();
    $startOfWeek = $today->copy()->startOfWeek(Carbon::MONDAY); // 月曜始まり
@endphp

<div class="mb-8">
    <h3 class="text-xl font-semibold mb-4 text-center">{{ $today->format('F, Y') }}</h3>

    <!-- 曜日 -->
    <div class="grid grid-cols-7 gap-2 justify-items-center mb-2">
        @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day)
            <div class="text-gray-500 text-xs">{{ $day }}</div>
        @endforeach
    </div>

    <!-- 日付 -->
    <div class="grid grid-cols-7 gap-2 justify-items-center">
        @for($i = 0; $i < 7; $i++)
            @php
                $date = $startOfWeek->copy()->addDays($i);
                $isToday = $date->isSameDay($today);
            @endphp
            <div class="p-2 rounded w-16 h-16 flex flex-col items-center justify-center bg-gray-100">
                <span class="text-sm">{{ $date->day }}</span>
                @if($isToday)
                    <div class="w-4 h-4 bg-green-500 rounded-full mt-1"></div>
                @endif
            </div>
        @endfor
    </div>
</div>


    <!-- Add Habit ボタン -->
    <a href="{{ route('add_habit') }}" 
       class="inline-block mb-6 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-200 mx-auto block">
        Add habits
    </a>

    <h1 class="text-3xl font-bold mb-6 text-center">List Habits</h1>

    <!-- 習慣一覧 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
        @foreach($habits as $habit)
            <div class="bg-white p-4 rounded-lg shadow-md max-w-sm mx-auto mb-6">
                <div class="flex justify-between items-start">
                    <!-- 習慣の詳細 -->
                    <div>
                        <p class="text-lg font-semibold">{{ $habit->name }}</p>
                        <p class="text-sm text-gray-500">{{ $habit->category }} | {{ $habit->date }}</p>
                    </div>

                    <!-- 操作ボタン -->
                    <div class="flex flex-col items-end space-y-2">
                        <div class="flex space-x-2">
                            <!-- 削除ボタン -->
                            <a href="{{ route('delete-habit', ['id' => $habit->id]) }}" 
                               class="px-4 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition text-sm w-20 text-center"
                               onclick="return confirm('Do you really wanna delete?');">
                                Delete
                            </a> 

                            <!-- START ボタン -->
                            <form action="{{ route('timer.start') }}" method="GET" class="flex">
                                <input type="hidden" name="name" value="{{ $habit->name }}">
                                <input type="hidden" name="category" value="{{ $habit->category }}">
                                <input type="hidden" name="date" value="{{ $habit->date }}">
                                <button type="submit"
                                        class="px-4 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition text-sm w-20 text-center">
                                    START
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
