<!-- resources/views/penalty.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Login Penalty</h1>
    <p>Unfortunately, your level has decreased due to inactivity.</p>
    <img src="{{ asset('images/loginpenalties.png') }}" alt="Penalty">
</div>
@endsection