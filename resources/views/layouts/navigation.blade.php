<!-- Navigation Bar -->
<nav class="bg-teal border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- ロゴ部分 -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
            </div>

            <!-- ナビゲーションバーの右側 -->
            <div class="hidden sm:-my-px sm:ms-6 sm:flex items-center space-x-4">
                @if (auth()->check())
                    <!-- ログイン中の表示 -->
                    <form method="POST" action="{{ route('logout') 
                    }}" class="inline-flex">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-gray-800">Logout</button>
                    </form>
                @else
                    <!-- ゲスト（未ログイン）の表示 -->
                    <a href="{{ route('login') }}" class="text-sm text-blue-500 underline">Log in</a>
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-blue-500 underline">Register</a>
                @endif
                    <!-- ユーザーアイコン -->
                    <div class="relative">
                        <img class="h-8 w-8 rounded-full" src="{{ auth()->user()->profile_photo_url ?? asset('images/default-user-icon.png') }}" alt="{{ auth()->user()->name }}">
                    </div>

                    <!-- ログアウトリンク -->
                    <!-- フォームを使用してログアウト処理を実行 -->
                    <form method="POST" action="{{ route('logout') }}" class="inline-flex">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-gray-800">Logout</button>
                    </form>
                @else
                    <!-- ゲスト用のリンク（ログインと登録） -->
                    <a href="{{ route('login') }}" class="text-sm text-blue-500 underline">Log in</a>
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-blue-500 underline">Register</a>
                @endif
            </div>

            <!-- モバイル用メニュー表示ボタン -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-teal-100 focus:outline-none focus:bg-teal-100 focus:text-gray-800 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- レスポンシブ設定（モバイル向け） -->
    @if (auth()->check())
        <div class="pt-4 pb-1 border-t border-gray-200 sm:hidden">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- プロフィール編集リンク -->
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- ログアウトフォーム -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-responsive-nav-link
                        href="#"
                        @click.prevent="$event.target.closest('form').submit()"
                    >
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    @else
        <div class="pt-4 pb-1 border-t border-gray-200 sm:hidden">
            <div class="px-4">
                <!-- ログインリンク -->
                <a href="{{ route('login') }}" class="text-sm text-blue-500 underline">Log in</a>
                <!-- 登録リンク -->
                <a href="{{ route('register') }}" class="ml-4 text-sm text-blue-500 underline">Register</a>
            </div>
        </div>
    @endif
</nav>