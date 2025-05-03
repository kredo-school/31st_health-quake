@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center bg-blue-100">
    <!-- 上部のエモジ表示 - 位置を調整 -->
    <div class="absolute top-32 w-full">
        <div class="flex justify-center space-x-4">
            <span class="text-3xl">🎊</span>
            <span class="text-3xl">🎉</span>
            <span class="text-3xl">🎈</span>
            <span class="text-3xl">🎊</span>
            <span class="text-3xl">🎉</span>
            <span class="text-3xl">🎈</span>
            <span class="text-3xl">🎊</span>
        </div>
    </div>

    <!-- 中央にタイトルと白いボックスを縦に並べる -->
    <div class="flex flex-col items-center space-y-16 mt-8">
        <!-- 中央のYou did it -->
        <h1 class="text-5xl md:text-6xl font-bold text-orange-500 text-center">
            You did it !!!!!
        </h1>

        <!-- 下部のレベル情報ボックス -->
        <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
            <div class="mb-6 text-center">
                <p class="text-xl text-gray-800">
                    Your level : <span class="font-bold text-2xl">{{ $currentLevel }}</span>
                </p>
            </div>

            <div class="flex justify-center my-6">
                <svg class="h-10 w-10 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </div>

            <div class="text-center">
                <p class="text-xl text-gray-800">
                    Level up : <span class="font-bold text-3xl text-green-600">{{ $nextLevel }}</span>
                </p>
            </div>

            @if (!isset($isRewardLevel) || !$isRewardLevel)
                <div class="text-center mt-2">
                    <p class="text-sm text-gray-600">
                        @if ($nextRewardLevel > 0)
                            (あと{{ $nextRewardLevel - $nextLevel }}レベルでご褒美がもらえます)
                        @endif
                    </p>
                </div>
            @endif

            <div class="mt-10 flex justify-center">
                <a href="{{ route('calendar.show', ['date' => now()->format('Y-m-d')]) }}"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                    Continue to Calendar
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // レベルが3の倍数のときはご褒美獲得ページへリダイレクト
    @if (isset($isRewardLevel) && $isRewardLevel)
        window.location.href = "{{ route('reward.earned', ['level' => $nextLevel]) }}";
    @else
        // 5秒後に自動的にカレンダー画面へリダイレクト
        setTimeout(function() {
            window.location.href = "{{ route('calendar.show', ['date' => now()->format('Y-m-d')]) }}";
        }, 5000);
    @endif
</script>
@endsection
