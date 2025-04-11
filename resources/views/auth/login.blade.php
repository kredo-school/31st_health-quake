@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-center items-center min-h-screen">
        <div class="w-full max-w-md">
            <div class="card-body text-center p-6">
                <!-- ロゴ -->
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo mx-auto mb-6">
                <!-- タイトルと説明文 -->
                <h2 class="text-2xl font-bold mb-4">Log in</h2>
                <p class="mb-6">Enter your username & password to log in this app</p>
                <!-- フォーム -->
                <form method="POST" action="{{ route('loginnew') }}">
                    @csrf
                    <!-- ユーザー名 -->
                    <div class="mb-4">
                        <input id="username" type="text" class="form-control w-full @error('username') is-invalid @enderror" name="username" placeholder="Username" value="{{ old('username') }}" required autofocus>
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <!-- パスワード -->
                    <div class="mb-4">
                        <input id="password" type="password" class="form-control w-full @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <!-- LOGINボタン -->
                    <div class="mb-4">
                        <button type="submit" class="btn btn-success w-full">Log in</button>
                    </div>
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