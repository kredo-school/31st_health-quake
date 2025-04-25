<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Quake - Admin Panel</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white border-r border-gray-200 shadow-md">
            <div class="p-4">
                <img src="/images/logo.png" alt="Logo" class="h-8 w-auto mx-auto">
            </div>
            <nav class="mt-6">
                <ul>
                    <li><a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Dashboard</a></li>
                    <li><a href="{{ route('admin.users') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Users</a></li>
                    <li><a href="{{ route('admin.login_penalties') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Login Penalties</a></li>
                    <li><a href="{{ route('admin.categories') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Categories</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</body>
</html>