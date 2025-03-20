@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-body text-center">
                <!-- ロゴ -->
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
                <!-- タイトルと説明文 -->
                <h2>Log in</h2>
                <p>Enter your username & passwor d to log in this app</p>
                <!-- フォーム -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- ユーザー名 -->
                     <input id="username" type="text" class="form-control mb-3 @error('username') is-invalid @enderror" name="username" placeholder="Username" value="{{ old('username') }}" required autofocus>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <!-- パスワード -->
                    <input id="password" type="password" class="form-control mb-3 @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    
                    <!-- LOGINボタン -->
                    <button type="submit" class="btn btn-success w-100">Log in</button>
                </form>
                <!-- 利用規約 -->
                <p class="mt-3 terms">
                    By clicking Log in, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection