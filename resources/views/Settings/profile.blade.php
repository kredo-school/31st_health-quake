<!-- resources/views/settings/profile.blade.php -->

@extends('layouts.app')

@section('content')

    <h1 class="text-2xl mb-4">プロフィール設定</h1>
    <form method="POST" action="{{ route('settings.update-profile') }}">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700">名前</label>
            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full border rounded p-2">
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">保存</button>
    </form>
@endsection