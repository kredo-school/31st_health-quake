@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-blue-100">
    <!-- カラフルな三角旗の画像 -->
    <div class="w-full max-w-md mb-8">
        <img src="{{ asset('images/bunting.png') }}" alt="Celebration bunting" class="w-full"
             onerror="this.style.display='none'; document.getElementById('emoji-bunting').style.display='block'">

        <!-- 画像が読み込めない場合の代替表示 -->
        <div id="emoji-bunting" class="text-center text-3xl hidden">
            🎊 🎉 🎈 🎊 🎉 🎈 🎊
        </div>
    </div>

    <h1 class="text-5xl md:text-6xl font-bold text-orange-500 mb-12 text-center animate-bounce">
        You did it !!!!!
    </h1>

    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
        <div class="mb-6">
            <p class="text-xl text-gray-800">
                Your level : <span class="font-bold text-2xl">{{ $currentLevel }}</span>
            </p>
        </div>

        <div class="flex justify-center my-6">
            <svg class="h-10 w-10 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </div>

        <div class="flex items-center justify-between">
            <p class="text-xl text-gray-800">
                Level up : <span class="font-bold text-3xl text-green-600">{{ $nextLevel }}</span>
            </p>
            @if ($nextRewardLevel > 0)
                <p class="text-sm text-gray-600">
                    (あと{{ $nextRewardLevel - $currentLevel }}レベルでご褒美がもらえます)
                </p>
            @endif
        </div>

        <div class="mt-10 flex justify-center">
            <a href="{{ route('calendar.show', ['date' => now()->format('Y-m-d')]) }}"
               class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                Continue to Calendar
            </a>
        </div>
    </div>
</div>

<script>
    // レベルが3の倍数のときはご褒美獲得ページへリダイレクト
    @if ($currentLevel % 3 == 0)
        window.location.href = "{{ route('reward.earned', ['level' => $currentLevel]) }}";
    @else
        // 5秒後に自動的にカレンダー画面へリダイレクト
        setTimeout(function() {
            window.location.href = "{{ route('calendar.show', ['date' => now()->format('Y-m-d')]) }}";
        }, 5000);
    @endif
</script>
@endsection
