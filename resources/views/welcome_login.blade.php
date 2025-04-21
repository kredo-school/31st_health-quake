@extends('layouts.app')
@section('content')
<div class="hero-section">
    <div class="container">
        <h1>The pain of effort is momentary, but the results last a lifetime.
            The choice is yours
            make a sacrifice now to find lifelong happiness,
            or sacrifice your future for momentary comfort and face lifelong regret
        </h1>
        <p>Makoto Nin,
            The originator of this app</p>

        <a href="/login-record" class="click-button">
            click here to continue
        </a>
    </div>
</div>
@endsection

@section("css")
<link rel="stylesheet" href="{{ asset("css/dashboard.css") }}">
@endsection
