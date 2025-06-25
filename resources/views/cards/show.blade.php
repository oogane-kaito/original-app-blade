@php


    $cardData = $businessCard ?? [
        'id' => null,
        'name' => '',
        'title' => '',
        'bio' => '',
        'avatar' => '/placeholder.svg?height=120&width=120',
        'theme' => 'nature',
        'backgroundColor' => '#f0fdf4',
        'textColor' => '#1f2937',
        'accentColor' => '#22c55e',
        'phone' => '',
        'email' => '',
        'links' => [],
        'visibility' => false
    ];

    // linksが配列でない場合の対処
    if (!is_array($cardData['links'])) {
        $cardData['links'] = [];
    }

    // visibilityの確実なboolean変換
    $cardData['visibility'] = (bool) $cardData['visibility'];

@endphp

<DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $cardData['name'] }} - デジタル名刺</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-orange-50 via-green-50 to-white">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-2xl mx-auto">
                 
                <x-ui.card-header>
                    <x-ui.card-title class="flex items-center gap-2 text-center justify-center">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        {{ $cardData['name'] }}の名刺
                    </x-ui.card-title>
                </x-ui.card-header>
                <x-ui.card-content>
                    <div id="preview-container">
                        <!-- プレビューコンテンツ -->
                        <div class="w-full max-w-sm mx-auto">
                            <div 
                                class="border-0 shadow-2xl overflow-hidden relative rounded-3xl"
                                style="background-color: {{ $cardData['backgroundColor'] }}"
                            >
                                <!-- Decorative elements -->
                                <div class="absolute top-4 right-4 opacity-20">
                                    <svg class="w-6 h-6" style="color: {{ $cardData['accentColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div class="absolute bottom-4 left-4 opacity-10">
                                    <svg class="w-8 h-8" style="color: {{ $cardData['accentColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                </div>
                                <div class="absolute top-8 left-6 opacity-15">
                                    <div class="w-3 h-3 rounded-full" style="background-color: {{ $cardData['accentColor'] }}"></div>
                                </div>
                                <div class="absolute bottom-8 right-6 opacity-15">
                                    <div class="w-2 h-2 rounded-full" style="background-color: {{ $cardData['accentColor'] }}"></div>
                                </div>

                                <div class="p-8 text-center relative z-10">
                                    <!-- Avatar -->
                                    <div class="mb-6">
                                        <div class="w-24 h-24 mx-auto border-4 border-white shadow-lg rounded-full overflow-hidden">
                                            <div 
                                                class="flex h-full w-full items-center justify-center rounded-full text-2xl font-bold text-white"
                                                style="background-color: {{ $cardData['accentColor'] }}"
                                            >
                                                {{ $cardData['name'] ? strtoupper(substr($cardData['name'], 0, 1)) : 'U' }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Name and Title -->
                                    <div class="mb-6">
                                        <h2 
                                            class="text-2xl font-bold mb-3" 
                                            style="color: {{ $cardData['textColor'] }}"
                                        >
                                            {{ $cardData['name'] ?: '名前未設定' }}
                                        </h2>
                                        @if($cardData['title'])
                                            <span 
                                                class="text-white border-0 px-4 py-2 rounded-full text-sm inline-block"
                                                style="background-color: {{ $cardData['accentColor'] }}"
                                            >
                                                {{ $cardData['title'] }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Bio -->
                                    @if($cardData['bio'])
                                        <div class="mb-8">
                                            <p 
                                                class="text-sm leading-relaxed whitespace-pre-line"
                                                style="color: {{ $cardData['textColor'] }}; opacity: 0.8"
                                            >
                                                {{ $cardData['bio'] }}
                                            </p>
                                        </div>
                                    @endif

                                    <!-- Email and Phone -->
                                    <div class="mb-6">
                                        @if($cardData['email'])
                                            <div class="text-sm mb-2" style="color: {{ $cardData['textColor'] }}">
                                                <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                {{ $cardData['email'] }}
                                            </div>
                                        @endif
                                        @if($cardData['phone'])
                                            <div class="text-sm" style="color: {{ $cardData['textColor'] }}">
                                                <span class="inline-block w-4 h-4 mr-1">📞</span>
                                                {{ $cardData['phone'] }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Links -->
                                    @if(count($cardData['links']) > 0)
                                        <div class="space-y-3">
                                            @foreach($cardData['links'] as $item)
                                                
                                                    <div
                                                        class="w-full justify-between group hover:shadow-lg transition-all duration-200 rounded-2xl border-2 p-3 cursor-pointer"
                                                        style="border-color: {{ $cardData['accentColor'] }}40; color: {{ $cardData['textColor'] }}"
                                                    >
                                                        <div class="flex items-center gap-3">
                                                            <svg class="w-5 h-5" style="color: {{ $cardData['accentColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path @if($item['icon'] === 'mail') stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" @else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9" @endif />
                                                            </svg>
                                                            <span class="font-medium">{{ $item['title'] ?: $item['icon'] }}</span>
                                                        </div>
                                                    </div>
                                                
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Footer -->
                                    <div class="mt-8 pt-6 border-t border-gray-200/50">
                                        <div class="flex items-center justify-center gap-2 text-xs opacity-60">
                                            <svg class="w-3 h-3" style="color: {{ $cardData['accentColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                            </svg>
                                            <span>Made with NatureLink</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-ui.card-content>
                
                <div class="mt-8 text-center">
                    @if(Auth::id() != $cardData->user_id && Auth::id())
                        <form action="{{ route('trades.request') }}" method="POST">
                            @csrf
                            <input type="hidden" name="card_id" value="{{ $cardData->id }}">
                            <input type="hidden" name="receiver_id" value="{{ $cardData->user_id }}">
                            <button type="submit" class="btn btn-primary">このカードを交換申請</button>
                        </form>
                    @endif
                    <p class="text-sm text-gray-600">
                        Powered by NatureLink
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>