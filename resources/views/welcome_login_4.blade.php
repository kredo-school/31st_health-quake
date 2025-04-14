@extends('layouts.app')
@section('content')

    <div class="container">
        <h1>The pain of effort is momentary, but the results last a lifetime. 
            The choice is yours
            make a sacrifice now to find lifelong happiness, 
            or sacrifice your future for momentary comfort and face lifelong regret
            </h1>
        {{-- <img src="images/logo.png" alt="Health Quake Logo" class="logo"> <!-- ロゴ画像のパスを指定 --> --}}
        <p>Makoto Nin,
            The originator of this app</p>
    </div>

@endsection

@section("css")
<link rel="stylesheet" href="{{ asset("css/dashboard_4.css") }}">

@endsection 