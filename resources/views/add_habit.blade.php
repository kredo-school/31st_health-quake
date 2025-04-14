<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Habit</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-blue-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        {{-- エラーメッセージ --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 成功メッセージ --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="text-2xl font-bold text-red-500 mb-6 text-center">Set your Habit</h2>

        <form action="{{ route('save_habit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block font-semibold mb-1">Habit name</label>
                <input type="text" id="name" name="name" required
                       class="w-full px-4 py-2 border border-gray-300 rounded appearance-none focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="options" class="block font-semibold mb-1">Category</label>
                <select id="options" name="category"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="Exercise Category">Exercise</option>
                    <option value="Nutrition Category">Nutrition</option>
                    <option value="Sleep Category">Sleep</option>
                    <option value="Other Categories">Other</option>
                </select>
            </div>

            <div>
                <label for="date" class="block font-semibold mb-1">Date</label>
                <input type="date" id="date" name="date" required
                       class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <button type="submit"
                    class="w-full bg-green-500 text-white font-bold py-2 rounded hover:bg-green-600 transition">
                Save
            </button>
        </form>

        <h3 class="mt-10 text-xl font-bold text-gray-800">Recommended Habits</h3>

        <div class="grid grid-cols-4 gap-3 mt-2">
            <div class="bg-blue-200 rounded-lg p-2 shadow">
                <img src="{{ asset('images/dont_smoke.jpg') }}" alt="Don't smoke" class="rounded mb-2">
                Don't smoke<p class="text-center font-semibold"></p>
            </div>
            <div class="bg-pink-200 rounded-lg p-2 shadow">
                <img src="{{ asset('images/glass_of_water.png') }}" alt="Glass of water" class="rounded mb-2">Drink water<p class="text-center font-semibold"></p>
            </div>
            <div class="bg-green-200 rounded-lg p-2 shadow">
                <img src="{{ asset('images/get_outside.jpg') }}" alt="Get outside" class="rounded mb-2">
                Get outside<p class="text-center font-semibold"></p>
            </div>
            <div class="bg-yellow-200 rounded-lg p-2 shadow">
                <img src="{{ asset('images/morning_exercise.jpg') }}" alt="Morning exercise" class="rounded mb-2">Morning exercise<p class="text-center font-semibold"></p>
            </div>
        </div>
    </div>
</body>
</html> 
