@extends('layouts.app')
@section('content')

    <div class="container">
        <h1>We are what we repeatedly do. 
            Excellence, then, is not an act, but a habit.
            </h1>
        {{-- <img src="images/logo.png" alt="Health Quake Logo" class="logo"> <!-- ロゴ画像のパスを指定 --> --}}
        <p>Aristotle,
            ancient Greek philosopher</p>
    </div>

@endsection

@section("css")
<link rel="stylesheet" href="{{ asset("css/dashboard_3.css") }}">

@endsection 