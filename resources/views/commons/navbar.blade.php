<header class="container sticky top-0 bg-transparent backdrop-blur-sm border-b border-gray-300 z-10 ">
    <nav class="navbar text-neutral-content sticky top-0 z-10 backdrop-blur-sm border-b border-gray-300">
        <div class="flex-1 flex items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-green-600 flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M5 3l14 9-14 9V3z" />
                    </svg>
                </div>
                <span class="text-lg lg:text-xl font-bold text-gray-600">デジタル名刺アプリ</span>
            </div>
        </div>

        <div class="">
            <ul class="menu hidden md:flex items-center gap-4 justify-between">
                @if (Auth::check())
                    {{-- ユーザー詳細ページへのリンク --}}
                    <li><a class="link link-hover" href="{{ route('users.show', Auth::user()->id) }}">{{ Auth::user()->name }}&#39;s profile</a></li>
    
                    {{-- ログアウトへのリンク --}}
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="link link-hover" href="#" onclick="event.preventDefault();this.closest('form').submit();">Logout</a>
                        </form>
                    </li>
                @else
                    {{-- ユーザー登録ページへのリンク --}}
                    <li><a class="link link-hover" href="{{ route('register') }}">Signup</a></li>
                    {{-- ログインページへのリンク --}}
                    <li><a class="link link-hover" href="{{ route('login') }}">Login</a></li>
                @endif
            </ul>

            {{-- モバイルナビゲーション用のドロップダウン --}}
            <div class="md:hidden">
                <div class="dropdown dropdown-end">
                    <button class="btn btn-ghost normal-case" onclick="toggleMobileMenu()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 6a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 6a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div id="mobile-menu" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg z-20">
                        <ul class="py-2">
                            @if (Auth::check())
                             
                                <li><a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="{{ route('users.show', Auth::user()->id) }}">{{ Auth::user()->name }}&#39;s profile</a></li>
                               
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="#" onclick="event.preventDefault();this.closest('form').submit();">Logout</a>
                                    </form>
                                </li>
                            @else
                                <li><a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="{{ route('register') }}">Signup</a></li>
                                <li><a class="block px-4 py-2 text-gray-800 hover:bg-gray-200" href="{{ route('login') }}">Login</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    }
</script>
