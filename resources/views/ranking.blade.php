{{-- filepath: c:\Users\user\Desktop\31st_health-quake\resources\views\ranking.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
   main {
        margin-top: 100px;
    }
</style>
<div class="min-h-screen pt-24">
    <!-- Main contents -->
    <main class="max-w-3xl mx-auto p-5 pt-8">
       
        <!-- Ranking Tabs -->
        {{-- <div class="flex justify-center mb-6">
            <div class="inline-flex rounded-md shadow-sm bg-white" role="group">
                @foreach (['level' => 'Level'] as $key => $label)
                    <a href="{{ route('ranking', ['type' => $key]) }}"
                       class="px-6 py-2.5 text-sm font-medium {{ $key === 'level' ? 'rounded-l-lg' : ($key === 'monthly' ? 'rounded-r-lg' : '') }} {{ $type === $key ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div> --}}

        <!-- Ranking Title -->
        <h2 class="text-xl font-bold text-center mb-6 text-gray-800">{{ $rankingTitle ?? 'Ranking' }}</h2>

        <!-- Ranking List -->
        @foreach ($ranks as $rank)
            <div class="flex items-center bg-white rounded-lg shadow-md p-4 mb-4 {{ $rank['position'] === $userPosition ? 'border-2 border-yellow-400' : '' }}">
                <img src="{{ $rank['avatar'] }}" alt="{{ $rank['name'] }}" class="w-12 h-12 rounded-full object-cover mr-4">
                <div>
                    <span class="text-xl font-bold text-gray-800 mr-2">#{{ $rank['position'] }}</span>
                    <span class="text-lg font-bold text-gray-800">{{ $rank['name'] }}</span>
                </div>

                <div class="ml-auto flex flex-col items-end">
                    @if ($rank['position'] === $userPosition)
                        <span class="text-xs text-gray-600 bg-yellow-100 px-2 py-1 rounded">YOU</span>
                    @endif
                    <span class="text-sm text-gray-600">{{ $rank['label'] ?? 'point' }}</span>
                    <span class="text-lg font-bold text-gray-800">{{ $rank['points'] }}</span>
                </div>
            </div>
        @endforeach
    </main>
</div>
@endsection