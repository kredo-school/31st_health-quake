@extends('admin.layout')

@section('content')
<h1 class="text-2xl font-bold mb-4">User management Dashboard</h1>
<main class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
<!-- サイドバー -->
<aside class="w-45 bg-white border-r p-4 sticky top-14">
    <div class="space-y-2"> 
        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Dashboard</a>
        <a href="{{ route('admin.login_penalties') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Login Penalties</a>
        {{-- <a href="{{ route('admin.categories') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">Categories</a> --}}
    </div>
</aside>

     <div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                    {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points</th> --}}
                    {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th> --}}
                </tr>
            </thead>
            
<tbody class="bg-white divide-y divide-gray-200">
    @forelse ($users as $user)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">{{ $user->username }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $user->level }}</td>
            {{-- <td class="px-6 py-4 whitespace-nowrap">{{ $user->points }}</td> --}}
            {{-- <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-block px-3 py-1 text-sm font-semibold leading-tight rounded-full {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($user->status) }}
                </span>
            </td> --}}
        </tr>
    @empty
        <tr>
            <td colspan="4" class="px-6 py-4 text-center">No users</td>
        </tr>
    @endforelse
</tbody>
              
            </table>
        </main>
    </div>
</div>
@endsection