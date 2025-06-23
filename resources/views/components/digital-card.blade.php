@props([
    'data' => []
])

@php
$iconMap = [
    'twitter' => 'globe',
    'instagram' => 'globe', 
    'linkedin' => 'globe',
    'github' => 'globe',
    'website' => 'globe',
    'mail' => 'mail'
];

function getIconClass($iconName) {
    global $iconMap;
    return $iconMap[$iconName] ?? 'globe';
}

// データの安全な取得
$cardData = is_array($data) ? $data : [];
$links = isset($cardData['links']) && is_array($cardData['links']) ? $cardData['links'] : [];
@endphp

<div class="w-full max-w-sm mx-auto">
    <x-ui.card 
        class="border-0 shadow-2xl overflow-hidden relative rounded-3xl"
        style="background-color: {{ $cardData['backgroundColor'] ?? '#f0fdf4' }}"
    >
        <!-- Decorative elements -->
        <div class="absolute top-4 right-4 opacity-20">
            <svg class="w-6 h-6" style="color: {{ $cardData['accentColor'] ?? '#22c55e' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>
        <div class="absolute bottom-4 left-4 opacity-10">
            <svg class="w-8 h-8" style="color: {{ $cardData['accentColor'] ?? '#22c55e' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
            </svg>
        </div>
        <div class="absolute top-8 left-6 opacity-15">
            <div class="w-3 h-3 rounded-full" style="background-color: {{ $cardData['accentColor'] ?? '#22c55e' }}"></div>
        </div>
        <div class="absolute bottom-8 right-6 opacity-15">
            <div class="w-2 h-2 rounded-full" style="background-color: {{ $cardData['accentColor'] ?? '#22c55e' }}"></div>
        </div>

        <x-ui.card-content class="p-8 text-center relative z-10">
            <!-- Avatar -->
            <div class="mb-6">
                <x-ui.avatar class="w-24 h-24 mx-auto border-4 border-white shadow-lg">
                    @if(!empty($cardData['avatar']) && $cardData['avatar'] !== '/placeholder.svg?height=120&width=120')
                        <img src="{{ $cardData['avatar'] }}" alt="{{ $cardData['name'] ?? '' }}" class="aspect-square h-full w-full object-cover" />
                    @else
                        <div class="flex h-full w-full items-center justify-center rounded-full text-2xl font-bold text-white" style="background-color: {{ $cardData['accentColor'] ?? '#22c55e' }}">
                            {{ !empty($cardData['name']) ? substr($cardData['name'], 0, 1) : 'U' }}
                        </div>
                    @endif
                </x-ui.avatar>
            </div>

            <!-- Name and Title -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold mb-3" style="color: {{ $cardData['textColor'] ?? '#1f2937' }}">
                    {{ $cardData['name'] ?? '' }}
                </h2>
                @if(!empty($cardData['title']))
                    <x-ui.badge 
                        class="text-white border-0 px-4 py-2 rounded-full text-sm"
                        style="background-color: {{ $cardData['accentColor'] ?? '#22c55e' }}"
                    >
                        {{ $cardData['title'] }}
                    </x-ui.badge>
                @endif
            </div>

            <!-- Bio -->
            @if(!empty($cardData['bio']))
                <div class="mb-8">
                    <p 
                        class="text-sm leading-relaxed whitespace-pre-line"
                        style="color: {{ $cardData['textColor'] ?? '#1f2937' }}; opacity: 0.8"
                    >
                        {{ $cardData['bio'] }}
                    </p>
                </div>
            @endif

            <!-- Email and Phone -->
            <div class="mb-6">
                @if(!empty($cardData['email']))
                    <div class="text-sm mb-2" style="color: {{ $cardData['textColor'] ?? '#1f2937' }}">
                        <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $cardData['email'] }}
                    </div>
                @endif
                @if(!empty($cardData['phone']))
                    <div class="text-sm" style="color: {{ $cardData['textColor'] ?? '#1f2937' }}">
                        <span class="inline-block w-4 h-4 mr-1">📞</span>
                        {{ $cardData['phone'] }}
                    </div>
                @endif
            </div>

            <!-- Links -->
            @if(!empty($links))
                <div class="space-y-3">
                    @foreach($links as $item)
                        @if(empty($item['delete']) || !$item['delete'])
                            <x-ui.button
                                variant="outline"
                                class="w-full justify-between group hover:shadow-lg transition-all duration-200 rounded-2xl border-2"
                                style="border-color: {{ ($cardData['accentColor'] ?? '#22c55e') . '40' }}; color: {{ $cardData['textColor'] ?? '#1f2937' }}"
                                onclick="window.open('{{ $item['url'] ?? '#' }}', '_blank')"
                            >
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5" style="color: {{ $cardData['accentColor'] ?? '#22c55e' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if(($item['icon'] ?? 'globe') === 'mail')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9" />
                                        @endif
                                    </svg>
                                    <span class="font-medium">{{ $item['title'] ?? '' }}</span>
                                </div>
                                <svg class="w-4 h-4 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </x-ui.button>
                        @endif
                    @endforeach
                </div>
            @endif

            <!-- Footer -->
            <div class="mt-8 pt-6 border-t border-gray-200/50">
                <div class="flex items-center justify-center gap-2 text-xs opacity-60">
                    <svg class="w-3 h-3" style="color: {{ $cardData['accentColor'] ?? '#22c55e' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    <span>Made with NatureLink</span>
                    <svg class="w-3 h-3" style="color: {{ $cardData['accentColor'] ?? '#22c55e' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Made with NatureLink</span>
                    <svg class="w-3 h-3" style="color: {{ $cardData['accentColor'] ?? '#22c55e' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </x-ui.card-content>
    </x-ui.card>
</div>
