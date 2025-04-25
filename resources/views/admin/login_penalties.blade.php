@extends('admin.layout')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Login Penalties</h1>
    <form action="{{ route('admin.login_penalties.update') }}" method="POST">
        @csrf
        <div class="bg-white shadow-md rounded my-6 p-4">
            <label for="inactive_days" class="block text-gray-700 text-sm font-bold mb-2">Inactive Days</label>
            <input type="number" id="inactive_days" name="inactive_days" value="{{ old('inactive_days', config('settings.inactive_days')) }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="bg-white shadow-md rounded my-6 p-4">
            <label for="penalty_level" class="block text-gray-700 text-sm font-bold mb-2">Penalty Level</label>
            <input type="number" id="penalty_level" name="penalty_level" value="{{ old('penalty_level', config('settings.penalty_level')) }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-4">
            Save
        </button>
    </form>
@endsection