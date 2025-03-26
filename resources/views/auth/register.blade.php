@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-center items-center min-h-screen">
        <div class="col-md-6">
            {{-- <div class="card register-card"> --}}
                <div class="card-body text-center">
                    <!-- ロゴ -->
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">

                    <!-- タイトルと説明文 -->
                    <h2>Create an account</h2>
                    <p>Enter your username & password to sign up for this app</p>

                    <!-- フォーム -->
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- 名前 -->
                        <input id="username" type="text" class="form-control mb-3 @error('username') is-invalid @enderror" name="username" placeholder="username" value="{{ old('username') }}" required autofocus>
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        {{-- <!-- Email -->
                        <input id="email" type="text" class="form-control mb-3 @error('email') is-invalid @enderror" name="email" placeholder="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror --}}

                        <!-- パスワード -->
                        <input id="password" type="password" class="form-control mb-3 @error('password') is-invalid @enderror" name="password" placeholder="password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                        <!-- パスワード確認 -->
                        <input id="password-confirm" type="password" class="form-control mb-3" name="password_confirmation" placeholder="password-confirm" required>

                        {{-- <!-- プロフィール画像 -->
                        <input id="profile_picture" type="text" class="form-control mb-3" name="profile_picture" placeholder="select photo | set your profile icon" value="{{ old('profile_picture') }}"> --}}

                        <!-- 登録ボタン -->
                        <button type="submit" class="btn btn-success w-100">Sign up</button>
                    </form>

                    <!-- 利用規約 -->
                    <p class="mt-3 terms">
                        By clicking Sign up, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                    </p>
                </div>
            {{-- </div> --}}
        </div>
    </div>
</div>
@endsection