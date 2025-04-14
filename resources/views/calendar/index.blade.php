@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Quake - Habit Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<main class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Latest Habits</h1>
    <!-- Latest habits list -->
    <div class="bg-white rounded-lg shadow-sm p-4">
        @foreach ($habits as $habit)
            <div class="category-item {{ $habit->category }}">{!! $habit->name !!}</div>
        @endforeach
    </div>
</main>
</body>
</html>
@endsection