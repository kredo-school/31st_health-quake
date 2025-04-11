<!-- resources/views/paper.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8" style="background: linear-gradient(135deg, #e0f7fa 0%, #bbdefb 100%); min-height: 100vh;">
    <div class="text-center mb-8">
        <h2 class="text-4xl font-bold py-2 px-6 inline-block" style="background: linear-gradient(90deg, #3949ab, #1e88e5); color: white; border-radius: 12px; box-shadow: 0 4px 10px rgba(25, 118, 210, 0.4); letter-spacing: 1.5px; transform: rotate(-1deg);">CONGRATULATIONS!</h2>

        <div class="mt-6 p-4 rounded-lg" style="background-color: rgba(255, 255, 255, 0.6); max-width: 800px; margin: 0 auto;">
            <p class="text-gray-700" style="font-size: 1.1rem; letter-spacing: 0.5px;">
                YOU HAVE LOGGED IN FOR <span style="color: #d81b60; font-weight: bold;">THREE CONSECUTIVE DAYS</span>,<br>
                AND WE WILL GIVE YOU HEALTH KNOWLEDGE BASED ON THE LATEST PAPERS.
            </p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <h3 class="text-2xl font-bold text-center mb-4 p-3" style="background-color: #4db6ac; color: white; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">{{ $paper['title'] }}</h3>

        @if(isset($paper['url']))
            <div class="text-center mb-6 animate-pulse">
                <a href="{{ $paper['url'] }}" target="_blank" class="hover:underline px-4 py-2 rounded-full" style="background-color: #64b5f6; color: white; font-weight: bold; transition: all 0.3s ease; display: inline-block; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                    <i class="fas fa-external-link-alt mr-2"></i>View Original Paper
                </a>
            </div>
        @endif

        <div class="rounded-lg shadow-xl p-6 mb-8" style="background-color: white; border-top: 5px solid #26a69a; position: relative; overflow: hidden;">
            <!-- Decorative corner -->
            <div style="position: absolute; top: 0; right: 0; width: 100px; height: 100px; background: linear-gradient(135deg, transparent 50%, #ffcc80 50%); border-radius: 0 0 0 100%;"></div>

            @if(isset($paper['content']['title']))
                <h4 class="text-xl font-bold mb-6 pb-3" style="border-bottom: 2px solid #e0e0e0; color: #37474f;">{{ $paper['content']['title'] }}</h4>
            @endif

            @if(isset($paper['content']['key_evidence']))
                <div class="mb-6 p-4 rounded-lg" style="background-color: #f5f5f5;">
                    <p class="mb-0"><span class="font-semibold" style="color: #1976d2;">Key Evidence:</span> {{ $paper['content']['key_evidence'] }}</p>
                </div>
            @endif

            @if(isset($paper['content']['main_finding']))
                <p class="mb-4 text-lg" style="color: #455a64;">{{ $paper['content']['main_finding'] }}</p>
            @endif

            @if(isset($paper['content']['conclusion']))
                <p class="mb-4 p-3 rounded-lg font-semibold" style="background-color: #e1f5fe; color: #0277bd;">{{ $paper['content']['conclusion'] }}</p>
            @endif

            @if(isset($paper['content']['findings']))
                <div class="mt-8 mb-6">
                    <h5 class="font-bold mb-4 text-center p-2" style="background-color: #ff7043; color: white; border-radius: 30px; max-width: 250px; margin: 0 auto;">MAIN FINDINGS</h5>
                    <ul class="space-y-3 my-4">
                        @foreach($paper['content']['findings'] as $finding)
                            <li class="p-3 rounded-lg flex items-start" style="background-color: #fff3e0; border-left: 4px solid #ff9800;">
                                <span style="color: #e65100; font-size: 20px; margin-right: 10px;">•</span>
                                <span>{{ $finding }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($paper['content']['core_findings']))
                <div class="mt-8 mb-6">
                    <h5 class="font-bold mb-4 text-center p-2" style="background-color: #5c6bc0; color: white; border-radius: 30px; max-width: 250px; margin: 0 auto;">CORE FINDINGS</h5>
                    <ul class="space-y-3 my-4">
                        @foreach($paper['content']['core_findings'] as $finding)
                            <li class="p-3 rounded-lg flex items-start" style="background-color: #e8eaf6; border-left: 4px solid #3f51b5;">
                                <span style="color: #3f51b5; font-size: 20px; margin-right: 10px;">•</span>
                                <span>{{ $finding }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($paper['content']['key_findings']))
                <div class="mt-8 mb-6">
                    <h5 class="font-bold mb-4 text-center p-2" style="background-color: #26a69a; color: white; border-radius: 30px; max-width: 250px; margin: 0 auto;">KEY FINDINGS</h5>
                    <ul class="space-y-3 my-4">
                        @foreach($paper['content']['key_findings'] as $finding)
                            <li class="p-3 rounded-lg flex items-start" style="background-color: #e0f2f1; border-left: 4px solid #009688;">
                                <span style="color: #00897b; font-size: 20px; margin-right: 10px;">•</span>
                                <span>{{ $finding }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($paper['content']['quality_matters']))
                <div class="mt-8 mb-6">
                    <h5 class="font-bold mb-4 text-center p-2" style="background-color: #ec407a; color: white; border-radius: 30px; max-width: 250px; margin: 0 auto;">QUALITY MATTERS</h5>
                    <ul class="space-y-3 my-4">
                        @foreach($paper['content']['quality_matters'] as $point)
                            <li class="p-3 rounded-lg flex items-start" style="background-color: #fce4ec; border-left: 4px solid #e91e63;">
                                <span style="color: #c2185b; font-size: 20px; margin-right: 10px;">•</span>
                                <span>{{ $point }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($paper['content']['affected_abilities']))
                <div class="mt-8 mb-6">
                    <h5 class="font-bold mb-4 text-center p-2" style="background-color: #7e57c2; color: white; border-radius: 30px; max-width: 250px; margin: 0 auto;">AFFECTED ABILITIES</h5>
                    <ul class="space-y-3 my-4">
                        @foreach($paper['content']['affected_abilities'] as $ability)
                            <li class="p-3 rounded-lg flex items-start" style="background-color: #ede7f6; border-left: 4px solid #673ab7;">
                                <span style="color: #5e35b1; font-size: 20px; margin-right: 10px;">•</span>
                                <span>{{ $ability }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($paper['content']['practical_applications']))
                <div class="mt-8 mb-6">
                    <h5 class="font-bold mb-4 text-center p-2" style="background-color: #66bb6a; color: white; border-radius: 30px; max-width: 300px; margin: 0 auto;">PRACTICAL APPLICATIONS</h5>
                    <ul class="space-y-3 my-4">
                        @foreach($paper['content']['practical_applications'] as $app)
                            <li class="p-3 rounded-lg flex items-start" style="background-color: #e8f5e9; border-left: 4px solid #4caf50;">
                                <span style="color: #2e7d32; font-size: 20px; margin-right: 10px;">•</span>
                                <span>{{ $app }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($paper['content']['real_life_tips']))
                <div class="mt-8 mb-6">
                    <h5 class="font-bold mb-4 text-center p-2" style="background-color: #ffa726; color: white; border-radius: 30px; max-width: 250px; margin: 0 auto;">REAL-LIFE TIPS</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($paper['content']['real_life_tips'] as $index => $tip)
                            <div class="p-4 rounded-lg flex items-start" style="background-color: #fff8e1; border: 1px dashed #ffb300;">
                                <span style="background-color: #ff9800; color: white; border-radius: 50%; width: 24px; height: 24px; display: flex; justify-content: center; align-items: center; margin-right: 10px;">{{ $index + 1 }}</span>
                                <span>{{ $tip }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(isset($paper['content']['study_info']))
                <div class="mt-8 mb-6 p-4 rounded-lg" style="background-color: #f3e5f5; border: 1px solid #ce93d8;">
                    <h5 class="font-bold mb-3 text-center" style="color: #6a1b9a;">WHY TRUST THIS STUDY?</h5>
                    <ul class="space-y-2">
                        @foreach($paper['content']['study_info'] as $info)
                            <li class="flex items-start">
                                <span style="color: #8e24aa; font-weight: bold; margin-right: 8px;">✓</span>
                                <span>{{ $info }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($paper['content']['source']))
                <div class="text-center mt-6 pt-4" style="border-top: 1px dashed #bdbdbd;">
                    <p class="italic" style="color: #78909c;">
                        <span style="display: inline-block; padding: 0 10px; position: relative;">
                            <span style="content: ''; position: absolute; left: -10px; top: 50%; width: 10px; height: 1px; background: #78909c;"></span>
                            Source: {{ $paper['content']['source'] }}
                            <span style="content: ''; position: absolute; right: -10px; top: 50%; width: 10px; height: 1px; background: #78909c;"></span>
                        </span>
                    </p>
                </div>
            @endif

            @if(isset($paper['content']['takeaway']) || isset($paper['content']['final_takeaway']))
                <div class="mt-8 p-4 rounded-lg text-center" style="background: linear-gradient(135deg, #bbdefb 0%, #90caf9 100%);">
                    <p class="font-bold text-lg" style="color: #0d47a1;">
                        {{ $paper['content']['takeaway'] ?? $paper['content']['final_takeaway'] }}
                    </p>
                </div>
            @endif
        </div>

        <div class="text-center mt-8 mb-10">
            <a href="{{ route('home') }}" class="inline-block font-semibold py-3 px-10 rounded-full transition-all duration-300 transform hover:scale-105" style="background: linear-gradient(to right, #42a5f5, #2196f3); color: white; box-shadow: 0 4px 10px rgba(33, 150, 243, 0.4); letter-spacing: 1px;">
                <i class="fas fa-home mr-2"></i> BACK TO HOME
            </a>
        </div>
    </div>
</div>

<!-- Add Font Awesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- Add some animations -->
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body {
        font-family: 'Poppins', sans-serif;
    }

    .animate-pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    /* Smooth hover effects for all interactive elements */
    a, li, .rounded-lg {
        transition: all 0.3s ease;
    }

    li:hover {
        transform: translateX(5px);
    }

    /* Animated background for extra visual appeal */
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .container {
        background-size: 200% 200%;
        animation: gradientBG 15s ease infinite;
    }
</style>
@endsection
