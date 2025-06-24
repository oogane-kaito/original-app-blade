{{-- より簡潔なバージョン --}}
<header class="containe px-4 py-4 sticky top-0 bg-transparent backdrop-blur-sm border-b border-gray-300 z-50 w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- ロゴ -->
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M5.5 3A1.5 1.5 0 004 4.5v11A1.5 1.5 0 005.5 17h9a1.5 1.5 0 001.5-1.5v-11A1.5 1.5 0 0014.5 3h-9zM8 7a1 1 0 000 2h4a1 1 0 100-2H8zm0 4a1 1 0 100 2h4a1 1 0 100-2H8z"/>
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-gray-900">デジタル名刺アプリ</h1>
            </div>

            <!-- デスクトップナビ -->
            <nav class="hidden md:flex items-center space-x-8">
                @auth
                    <a href="{{ route('editor.index') }}" 
                       class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-700 font-medium hover:text-gray-90">
                        名刺編集画面
                    </a>
                    <a href="{{ route('profile.edit') }}" 
                       class="text-gray-600 hover:text-gray-900 font-medium">
                        ユーザー設定
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-red-600 font-medium">
                            ログアウト
                        </button>
                    </form>
                @else
                    <a href="{{ route('register') }}" class="text-white  px-4 py-2 hover:text-gray-900 font-medium bg-orange-300 rounded-md hover:bg-orange-700">
                        新規登録
                    </a>
                    <a href="{{ route('login') }}" 
                       class="bg-green-300 text-white px-4 py-2 rounded-md hover:bg-green-700 font-medium hover:text-gray-900" >
                        ログイン
                    </a>
                @endauth
            </nav>

            <!-- モバイルメニューボタン -->
            <button 
                class="md:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100"
                onclick="document.getElementById('mobile-menu').classList.toggle('hidden')"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- モバイルメニュー -->
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <div class="space-y-1">
                @auth
                    <a href="{{ route('editor.index') }}" 
                       class="bg-green-300 text-white px-4 py-2 rounded-md hover:bg-green-700 font-medium hover:text-gray-90">
                        名刺編集画面
                    </a>
                    <a href="{{ route('profile.edit') }}" 
                       class="block px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md">
                        ユーザー設定
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full text-left px-3 py-2 text-gray-600 hover:text-red-600 hover:bg-gray-50 rounded-md">
                            ログアウト
                        </button>
                    </form>
                @else
                    <a href="{{ route('register') }}" 
                       class="block px-3 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md bg-orange-300">
                        新規登録
                    </a>
                    <a href="{{ route('login') }}" 
                       class="block px-3 py-2 bg-green-300 text-white hover:bg-green-700 rounded-md text-center">
                        ログイン
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>