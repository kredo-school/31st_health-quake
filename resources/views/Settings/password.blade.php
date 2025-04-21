<!-- resources/views/settings/password.blade.php -->

@extends('layouts.app')

@section('content')
    <h1 class="text-2xl mb-4">パスワード変更</h1>
    <form method="POST" action="{{ route('settings.update-password') }}">
        @csrf
        <div class="mb-4">
            <label for="current_password" class="block text-gray-700">現在のパスワード</label>
            <input type="password" id="current_password" name="current_password" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label for="new_password" class="block text-gray-700">新しいパスワード</label>
            <input type="password" id="new_password" name="new_password" class="w-full border rounded p-2">
        </div>
        <div class="mb-4">
            <label for="new_password_confirmation" class="block text-gray-700">新しいパスワード（確認用）</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full border rounded p-2">
        </div>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">変更</button>
    </form>
@endsection