@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-orange-50 via-green-50 to-white">
    <div class="container mx-auto px-4 py-8 sm:py-12 lg:py-16 text-center">
        <div class="max-w-4xl mx-auto space-y-8">
            <div class="flex justify-center mb-4 sm:mb-6">
                <div class="relative">
                    <svg class="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 text-orange-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <div class="absolute -top-1 -right-1 sm:-top-2 sm:-right-2 w-3 h-3 sm:w-4 sm:h-4 bg-green-300 rounded-full animate-bounce"></div>
                    <div class="absolute -bottom-1 -left-1 w-2 h-2 sm:w-3 sm:h-3 bg-orange-300 rounded-full animate-ping"></div>
                </div>
            </div>

            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold mb-4 sm:mb-6 leading-tight text-shadow">
                <span class="bg-gradient-to-r from-orange-600 to-green-600 bg-clip-text text-transparent">やさしい</span>
                <br />
                <span class="text-gray-800">デジタル名刺で</span>
                <br />
                <span class="bg-gradient-to-r from-green-600 to-orange-600 bg-clip-text text-transparent">つながろう！</span>
            </h1>

            <p class="text-base sm:text-lg lg:text-xl text-gray-600 mb-6 sm:mb-8 max-w-2xl mx-auto px-4 leading-relaxed">
                自然でやさしいデザインのデジタル名刺を作って、
                <br class="hidden sm:block" />
                大切な人とのつながりを育てていこう 🌱
            </p>

            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4">
                <a href="{{ route('register') }}">
                    <x-ui.button
                        size="lg"
                        class="w-full sm:w-auto bg-gradient-to-r from-orange-300 to-green-400 hover:from-orange-500 hover:to-green-500 text-white rounded-full px-6 sm:px-8 py-3 text-base sm:text-lg shadow-lg flex items-center justify-center button-hover"
                    >
                        無料で利用する
                    </x-ui.button>
                </a>
            </div>
        </div>
    </div>
    <!-- Features Section -->
    <section class="container mx-auto px-4 py-8 sm:py-12 lg:py-16">
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 mb-3 sm:mb-4">デジタル名刺サイトの特徴</h2>
            <p class="text-base sm:text-lg text-gray-600">やさしく・楽しく・つながる3つのポイント</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 max-w-6xl mx-auto">
            <x-ui.card class="border-0 shadow-lg bg-white hover:shadow-xl transition-all duration-300 hover:-translate-y-1 rounded-3xl">
                <x-ui.card-content class="p-6 sm:p-8 text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-r from-orange-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                        <Palette className="w-6 h-6 sm:w-8 sm:h-8 text-white" />
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 sm:mb-3">やさしいデザイン</h3>
                    <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                        自然をイメージした落ち着いたカラーで、見る人の心を和ませるデザインです
                    </p>
                </x-ui.card-content>
            </x-ui.card>

            <x-ui.card class="border-0 shadow-lg bg-white hover:shadow-xl transition-all duration-300 hover:-translate-y-1 rounded-3xl">
                <x-ui.card-content class="p-6 sm:p-8 text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-r from-green-400 to-green-500 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                        <Share2 className="w-6 h-6 sm:w-8 sm:h-8 text-white" />
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 sm:mb-3">かんたんシェア</h3>
                    <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                        1つのリンクで全てをまとめて共有。お友達との交換も楽しくできます
                    </p>
                </x-ui.card-content>
            </x-ui.card>

            <x-ui.card class="border-0 shadow-lg bg-white hover:shadow-xl transition-all duration-300 hover:-translate-y-1 rounded-3xl md:col-span-2 lg:col-span-1">
                <x-ui.card-content class="p-6 sm:p-8 text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-r from-green-500 to-orange-400 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                        <Users className="w-6 h-6 sm:w-8 sm:h-8 text-white" />
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 sm:mb-3">つながりを大切に</h3>
                    <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                        交換した名刺を整理して、大切な人とのつながりを育てていけます
                    </p>
                </x-ui.card-content>
            </x-ui.card>
        </div>
    </section>

    <!-- Fun Section -->
    <section class="container mx-auto px-4 py-8 sm:py-12 lg:py-16">
        <div class="bg-gradient-to-r from-orange-100 to-green-100 rounded-2xl sm:rounded-3xl p-6 sm:p-8 lg:p-12 text-center mx-4 sm:mx-0">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 mb-3 sm:mb-4">みんなで楽しく使おう！</h2>
            <p class="text-base sm:text-lg lg:text-xl text-gray-600 mb-6 sm:mb-8 leading-relaxed">
                学校のお友達、習い事の仲間、家族みんなで
                <br class="hidden sm:block" />
                素敵なデジタル名刺を作って交換しよう
            </p>
            <Link href="{{ route('register') }}">
                <x-ui.button
                    size="lg"
                    class="w-full sm:w-auto bg-white text-orange-600 hover:bg-orange-50 rounded-full px-6 sm:px-8 py-3 text-base sm:text-lg font-semibold shadow-lg"
                >
                    <Star className="w-4 h-4 sm:w-5 sm:h-5 mr-2" />
                    今すぐ作ってみる
                </x-ui.button>
            </Link>
        </div>
    </section>
</div>
@endsection