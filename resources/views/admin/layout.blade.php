@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'Health Quake') }}</title>
    
        <!-- Tailwind CSS -->
        @vite('resources/css/app.css') 
        @yield('css') 
    </head>
    <body class="bg-gray-100 font-sans leading-normal tracking-normal">
        <div class="flex h-screen">
            <!-- Sidebar -->
            <aside id="sidebar" class="w-64 bg-white border-r border-gray-200 shadow-md">
                <div class="p-4">
                    <img src="/images/logo.png" alt="Logo" class="h-8 w-auto mx-auto">
                </div>
                <nav class="mt-6">
                    <ul>
                        <li><a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Dashboard</a></li>
                        {{-- <li><a href="{{ route('admin.users') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Users</a></li> --}}
                        <li><a href="{{ route('admin.login_penalties') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Login Penalties</a></li>
                        <li><a href="{{ route('admin.categories') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Categories</a></li>
                    </ul>
                </nav>
            </aside>
    
            <!-- Main Content Area -->
            <div class="flex-1 p-4">
                <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
                <!-- Add your dashboard content here -->
            </div>
        </div>
    </body>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            {{-- @yield('content') --}}
        </main>
    </div>
    
</body>
</html>