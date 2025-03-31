<!-- resources/views/task/index.blade.php -->

@extends('layouts.app') <!-- 既存のレイアウトファイルを使用 -->

@section('content')
    <div class="container">
        <h1>{{ $exerciseCategory }}, Exercise Category, {{ $date }}</h1>
        <div class="timer">{{ $timeElapsed }}<br><small>Time counted from start</small></div>
        <a href="#" class="button done">DONE</a>
        <a href="#" class="button stop">STOP</a>
        <a href="#" class="button quit">QUIT TASKS</a>
    </div>
@endsection