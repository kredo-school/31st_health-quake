@extends('admin.layout')

@section('content')
<h1 class="text-2xl font-bold mb-4">User Management</h1>
<div class="bg-white shadow-md rounded my-6">
    <div class="border-b border-gray-200">
        <ul class="flex space-x-4 px-4 py-2">
            <li><a href="#" class="text-gray-500 hover:text-gray-700">All Users</a></li>
            <li><a href="#" class="text-gray-500 hover:text-gray-700">Active</a></li>
            <li><a href="#" class="text-gray-500 hover:text-gray-700">Inactive</a></li>
        </ul>
    </div>
    <div class="p-4">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->level }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->points }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-block px-3 py-1 text-sm font-semibold leading-tight rounded-full {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection