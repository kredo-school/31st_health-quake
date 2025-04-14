@extends('layouts.app')
@section('content')

    <div class="container">
        <h1>Whatever the cost, whatever the danger, 
            the greatest of all dangers is to do nothing.
            </h1>
        {{-- <img src="images/logo.png" alt="Health Quake Logo" class="logo"> <!-- ロゴ画像のパスを指定 --> --}}
        <p class="author">John F. Kennedy Politician</p>
    </div>
    <a href="/login-record" class=click>
        click here to continue
       </a>
@endsection

@section("css")
<link rel="stylesheet" href="{{ asset("css/dashboard.css") }}">

@endsection