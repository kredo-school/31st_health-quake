<!-- resources/views/profile.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10 max-w-md">
    <h2 class="text-xl font-bold mb-6">Edit your profile</h2>

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
                 class="h-24 w-24 rounded-full object-cover border">
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
@endsection
