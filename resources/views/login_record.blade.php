<!-- resources/views/login_record.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Login Record</h1>
    <p>Consecutive Days: {{ $user->consecutive_days }}</p>
    <p>Level: {{ $user->level }}</p>

    @if($bonusMessage)
        <div class="alert alert-success">
            {{ $bonusMessage }}
            <a href="{{ route('bonus.show') }}">Click here</a>
        </div>
    @endif

    @if($penaltyMessage)
        <div class="alert alert-danger">
            {{ $penaltyMessage }}
        </div>
    @endif

    <!-- 「Let's set the Bonus」ボタン -->
    <div class="mt-8 text-center">
        <a href="{{ route('rewards.index') }}" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-md shadow-md transition-all inline-block">
            SET YOUR BONUS
        </a>
    </div>
</div>
@endsection