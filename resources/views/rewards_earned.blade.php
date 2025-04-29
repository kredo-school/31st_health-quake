@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-blue-100">
    <!-- お祝いアニメーション -->
    <div class="w-full max-w-md mb-8">
        <img src="{{ asset('images/celebrate.png') }}" alt="Celebration" class="w-full"
             onerror="this.style.display='none'; document.getElementById('emoji-celebration').style.display='block'">

        <!-- 画像が読み込めない場合の代替表示 -->
        <div id="emoji-celebration" class="text-center text-3xl hidden">
            🎉 🎊 🏆 🎁 🎉 🎊 🏆 🎁
        </div>
    </div>

    <h1 class="text-5xl md:text-6xl font-bold text-purple-600 mb-8 text-center animate-pulse">
        おめでとう！
    </h1>

    <h2 class="text-3xl font-bold text-indigo-500 mb-12 text-center">
        ご褒美をゲットしました！
    </h2>

    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
        <div class="mb-6 text-center">
            <div class="overflow-hidden rounded-lg shadow-lg mb-6 transform transition duration-500 hover:scale-105">
                <img src="{{ $reward['image'] }}" alt="{{ $reward['name'] }}" class="w-full h-64 object-cover">
            </div>

            <p class="text-2xl font-bold text-gray-800 mb-4">{{ $reward['name'] }}</p>

            <div class="inline-block bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded-full mb-6">
                Level {{ $currentLevel }} 達成報酬
            </div>

            <p class="text-gray-600 mb-6">
                ご褒美を楽しんでください！<br>
                次のご褒美はレベル {{ $nextRewardLevel }} で獲得できます
            </p>
        </div>

        <div class="mt-8 flex justify-center">
            <a href="{{ route('calendar.show', ['date' => now()->format('Y-m-d')]) }}"
               class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                続ける
            </a>
        </div>
    </div>
</div>

<script>
    // 紙吹雪アニメーション効果
    document.addEventListener('DOMContentLoaded', function() {
        createConfetti();
    });

    function createConfetti() {
        const confettiCount = 200;
        const container = document.querySelector('body');

        for (let i = 0; i < confettiCount; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'absolute';
            confetti.style.width = Math.random() * 10 + 5 + 'px';
            confetti.style.height = Math.random() * 10 + 5 + 'px';
            confetti.style.background = getRandomColor();
            confetti.style.position = 'fixed';
            confetti.style.top = '-10px';
            confetti.style.left = Math.random() * 100 + 'vw';
            confetti.style.opacity = Math.random() + 0.5;
            confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
            confetti.style.zIndex = '1000';
            confetti.style.transformOrigin = 'center center';
            confetti.style.transform = 'rotate(' + Math.random() * 360 + 'deg)';

            container.appendChild(confetti);

            animateConfetti(confetti);
        }
    }

    function animateConfetti(confetti) {
        const speed = 3 + Math.random() * 5;
        const rotation = Math.random() * 360;
        const xMovement = (Math.random() - 0.5) * 20;
        let y = 0;

        const tick = () => {
            y += speed;
            const x = xMovement * Math.sin(y / 30);

            confetti.style.transform = `translate3d(${x}px, ${y}px, 0) rotate(${rotation + y}deg)`;

            if (y < window.innerHeight) {
                requestAnimationFrame(tick);
            } else {
                confetti.remove();
            }
        };

        tick();
    }

    function getRandomColor() {
        const colors = ['#FF9999', '#99FF99', '#9999FF', '#FFFF99', '#FF99FF', '#99FFFF'];
        return colors[Math.floor(Math.random() * colors.length)];
    }

    // 10秒後に自動的にカレンダー画面へリダイレクト
    setTimeout(function() {
        window.location.href = "{{ route('calendar.show', ['date' => now()->format('Y-m-d')]) }}";
    }, 10000);
</script>
@endsection
