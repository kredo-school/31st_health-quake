<!-- resources/views/profile.blade.php -->
{{-- アイコン画像をクリックした時のページ --}}
@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg mx-auto mt-10">
    <div class="container mx-auto mt-10 max-w-md">
        <h1 class=" font-bold mb-6">Your profile</h1>

            <!-- ユーザーレベルの表示 -->
            <div class="mb-4">
                <p class="font-semibold mb-1">Your Level：</p>
                <p class="text-lg font-bold text-blue-600">{{ $level }}</p>
            </div>

        

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- 現在のプロフィール画像 -->
            <div class="mb-4">
                <p class="font-semibold mb-1">Your Icon：</p>
                <img src="{{ $user->profile_photo_url ?? asset('images/default-user-icon.png') }}"
                     alt="your icon"
                     class="h-24 w-24 rounded-full object-cover border mx-auto">
            </div>


            <!-- 新しい画像のアップロード -->
            <div class="mb-4">
                <label for="profile_photo" class="block font-semibold mb-1">New Icon：</label>
                <input type="file" name="profile_photo" id="profile_photo"
                       class="form-control @error('profile_photo') is-invalid @enderror">
                @error('profile_photo')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- 送信ボタン -->
            <button type="submit" class="btn btn-primary w-full">Update</button>
        </form>
    </div>
</div>
@endsection
