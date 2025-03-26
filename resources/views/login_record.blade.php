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
</div>
@endsection