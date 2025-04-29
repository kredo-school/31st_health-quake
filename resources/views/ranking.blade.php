@extends('layouts.app')

@section('content')
<div class="bg-blue-100 min-h-screen">
    <!-- Main contents -->
    <main class="max-w-3xl mx-auto p-5 pt-8">
        <!-- Ranking Tabs -->
        <div class="flex justify-center mb-6">
            <div class="inline-flex rounded-md shadow-sm bg-white" role="group">
                <a href="{{ route('ranking', ['type' => 'level']) }}"
                   class="px-6 py-2.5 text-sm font-medium rounded-l-lg {{ $type === 'level' ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    レベル
                </a>
                <a href="{{ route('ranking', ['type' => 'weekly']) }}"
                   class="px-6 py-2.5 text-sm font-medium {{ $type === 'weekly' ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    週間
                </a>
                <a href="{{ route('ranking', ['type' => 'monthly']) }}"
                   class="px-6 py-2.5 text-sm font-medium rounded-r-lg {{ $type === 'monthly' ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    月間
                </a>
            </div>
        </div>

        <!-- Ranking Title -->
        <h2 class="text-xl font-bold text-center mb-6 text-gray-800">{{ $rankingTitle ?? 'ランキング' }}</h2>

        <!-- Ranking List -->
        @foreach ($ranks as $rank)
            <div class="flex items-center bg-white rounded-lg shadow-md p-4 mb-4 {{ $rank['position'] === $userPosition ? 'border-2 border-yellow-400' : '' }}">
                <img src="{{ $rank['avatar'] }}" alt="{{ $rank['name'] }}" class="w-12 h-12 rounded-full object-cover mr-4">
                <div>
                    <span class="text-xl font-bold text-gray-800 mr-2">#{{ $rank['position'] }}</span>
                    <span class="text-lg font-bold text-gray-800">{{ $rank['name'] }}</span>
                </div>
                <div class="ml-auto flex flex-col items-end">
                    <span class="text-sm text-gray-600">{{ $rank['label'] ?? 'ポイント' }}</span>
                    <span class="text-lg font-bold text-gray-800">{{ $rank['points'] }}</span>
                </div>

                @if ($rank['position'] === $userPosition)
                    <div class="relative ml-3">
                        <span class="text-xs text-gray-600 ml-1 bg-yellow-100 px-2 py-1 rounded">あなた</span>
                    </div>
                @endif
            </div>
        @endforeach
    </main>
</div>
@endsection
