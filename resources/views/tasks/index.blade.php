@extends('layouts.app')

@section('content')
<h1>タスクリスト</h1>
<ul>
    @foreach ($tasks as $task)
    <li>
        {{ $task->name }} (予定時間: {{ $task->scheduled_time ?? '未設定' }})
        <form method="POST" action="{{ route('tasks.update', $task->id) }}">
            @csrf @method('PUT')
            <button type="submit">完了</button>
        </form>
    </li>
    @endforeach
</ul>
@endsection