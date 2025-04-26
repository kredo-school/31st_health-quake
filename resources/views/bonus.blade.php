<!-- resources/views/bonus.blade.php -->
@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-12 text-center" style="background-color: #E0F7FA; border-radius: 12px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);">
    <div class="mb-10">
        <h4 class="text-lg font-semibold text-gray-800" style="letter-spacing: 1px;">CONSECUTIVE DAYS WITH LOGGING IN :</h4>
        <h3 class="text-4xl font-bold text-gray-800 mt-2" style="letter-spacing: 2px;">3 DAYS</h3>
    </div>
    <div class="mb-10">
        <h2 class="text-3xl font-bold" style="color: #FF7043; font-family: 'Poppins', sans-serif;">YOU'RE DOING GREAT!</h2>
        <h3 class="text-xl mt-3" style="color: #FF7043; letter-spacing: 0.5px;">HERE'S A BONUS FOR LOGGING IN THREE DAYS IN A ROW</h3>
    </div>
    <!-- Centered star with click functionality -->
    <div class="flex justify-center items-center my-12">
        <a href="{{ route('bonus.paper') }}" class="bonus-star-container">
            <div class="bonus-star"></div>
            <div class="bonus-ribbon">BONUS</div>
            <div class="click-text">PLEASE CLICK HERE</div>
        </a>
    </div>
</div>
<!-- Add custom fonts and styles -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
    .container {
        font-family: 'Poppins', sans-serif;
    }
    /* Create a custom star with bonus ribbon */
    .bonus-star-container {
        position: relative;
        width: 220px;
        height: 220px;
        cursor: pointer;
        transition: transform 0.3s ease;
        display: block;
        margin: 0 auto;
    }
    .bonus-star {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z" fill="%23FFA726" stroke="%23FF9800" stroke-width="0.5"/></svg>');
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        filter: drop-shadow(0 4px 8px rgba(255, 152, 0, 0.5));
    }
    .bonus-ribbon {
        position: absolute;
        top: 43%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #D32F2F;
        color: white;
        font-weight: bold;
        padding: 5px 20px;
        font-size: 1.5rem;
        letter-spacing: 1px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        border-radius: 3px;
        z-index: 10;
    }
    .click-text {
        position: absolute;
        bottom: -40px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #29B6F6;
        color: white;
        font-weight: bold;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        letter-spacing: 1px;
        box-shadow: 0 2px 6px rgba(41, 182, 246, 0.4);
        transition: all 0.3s ease;
        white-space: nowrap;
    }
    .bonus-ribbon:before, .bonus-ribbon:after {
        content: '';
        position: absolute;
        top: 50%;
        width: 20px;
        height: 2px;
        background: #D32F2F;
    }
    .bonus-ribbon:before {
        left: -20px;
        transform: translateY(-50%);
    }
    .bonus-ribbon:after {
        right: -20px;
        transform: translateY(-50%);
    }
    /* Animation effects when interacted with */
    .bonus-star-container:hover {
        transform: scale(1.1) rotate(5deg);
    }
    .bonus-star-container:hover .click-text {
        background-color: #1E88E5;
        transform: translateX(-50%) scale(1.1);
        box-shadow: 0 4px 10px rgba(41, 182, 246, 0.6);
    }
    .bonus-star-container:active {
        transform: scale(0.95);
    }
    /* Add a pulsing animation */
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    .bonus-star-container {
        animation: pulse 2s infinite;
    }
    /* Smaller pulse for "PLEASE CLICK HERE" text */
    @keyframes textPulse {
        0% { transform: translateX(-50%) scale(1); }
        50% { transform: translateX(-50%) scale(1.05); }
        100% { transform: translateX(-50%) scale(1); }
    }
    .click-text {
        animation: textPulse 2s infinite;
    }
    /* Stop the pulsing animation on hover to prevent conflict with hover animation */
    .bonus-star-container:hover {
        animation: none;
        transform: scale(1.1) rotate(5deg);
    }
    .bonus-star-container:hover .click-text {
        animation: none;
    }
</style>
<script>
    // Add interactive effects with JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        const starContainer = document.querySelector('.bonus-star-container');
        // Add a "sparkle" effect when clicked
        starContainer.addEventListener('click', function(e) {
            // Don't prevent default so the link still works
            this.classList.add('clicked');
            // Create sparkle elements
            for (let i = 0; i < 15; i++) {
                const sparkle = document.createElement('div');
                sparkle.classList.add('sparkle');
                // Random position around the star
                const angle = Math.random() * Math.PI * 2;
                const distance = 70 + Math.random() * 40;
                const posX = Math.cos(angle) * distance;
                const posY = Math.sin(angle) * distance;
                sparkle.style.left = `calc(50% + ${posX}px)`;
                sparkle.style.top = `calc(50% + ${posY}px)`;
                // Random size
                const size = 3 + Math.random() * 7;
                sparkle.style.width = `${size}px`;
                sparkle.style.height = `${size}px`;
                // Random color (gold/yellow variations)
                const hue = 40 + Math.random() * 20;
                sparkle.style.backgroundColor = `hsl(${hue}, 100%, 65%)`;
                // Add to container
                this.appendChild(sparkle);
            }
        });
    });
</script>
<style>
    /* Additional styles for the sparkle effect */
    .bonus-star-container {
        overflow: visible;
    }
    .sparkle {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        animation: sparkleAnimation 1s forwards;
        z-index: 20;
    }
    @keyframes sparkleAnimation {
        0% {
            transform: scale(0) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: scale(1.5) rotate(45deg);
            opacity: 0;
        }
    }
    .clicked .bonus-star {
        animation: starClickEffect 0.5s;
    }
    @keyframes starClickEffect {
        0% { transform: scale(1); }
        50% { transform: scale(0.85); }
        75% { transform: scale(1.15); }
        100% { transform: scale(1); }
    }
</style>
@endsection