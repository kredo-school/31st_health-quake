@extends('layouts.app')

@section('content')
<h1>{{ $habit->date }} の記録</h1>
<p>レベル: {{ $habit->level }}</p>
<ul>
    @foreach ($habit->completed_tasks as $task)
    <li>{{ $task }}</li>
    @endforeach
</ul>
@endsection