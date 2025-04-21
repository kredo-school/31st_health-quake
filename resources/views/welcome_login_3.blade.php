@extends('layouts.app')
@section('content')

    <div class="container">
        <h1>We are what we repeatedly do.
            Excellence, then, is not an act, but a habit.
            </h1>

        <p>Aristotle,
            ancient Greek philosopher</p>
            <a href="/login-record" class="continue-btn">click here to continue</a>
    </div>

@endsection

@section("css")
<link rel="stylesheet" href="{{ asset("css/dashboard_3.css") }}">

@endsection
