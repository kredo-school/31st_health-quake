@extends('admin.layout')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Category Management</h1>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- サイドバー -->
        <aside class="w-45 bg-white border-r p-4 sticky top-14">
            <div class="space-y-2"> 
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Dashboard</a>
                <a href="{{ route('admin.login_penalties') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Login Penalties</a>
                <a href="{{ route('admin.categories') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Categories</a>
            </div>
        </aside>
    <form action="{{ route('admin.categories.update') }}" method="POST">
        @csrf
        <div class="bg-white shadow-md rounded my-6 p-4">
            <label for="category_name" class="block text-gray-700 text-sm font-bold mb-2">Category Name</label>
            <input type="text" id="category_name" name="category_name" value="{{ old('category_name', config('settings.category_name')) }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">
            Save
        </button>
    </form>
@endsection