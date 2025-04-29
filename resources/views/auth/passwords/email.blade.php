@extends('layouts.app')
@section('content')
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Set new password') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" required autofocus />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- 新しいパスワード -->
        <div class="mt-4">
            <x-input-label for="new_password" :value="__('New password')" />
            <x-text-input id="new_password" class="block mt-1 w-full" type="password" name="new_password" required />
            <x-input-error :messages="$errors->get('new_password')" class="mt-2" />
        </div>

        <!-- 新しいパスワード (確認) -->
        <div class="mt-4">
            <x-input-label for="new_password_confirmation" :value="__('New password (confirm)')" />
            <x-text-input id="new_password_confirmation" class="block mt-1 w-full" type="password" name="new_password_confirmation" required />
            <x-input-error :messages="$errors->get('new_password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Update the password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
@endsection