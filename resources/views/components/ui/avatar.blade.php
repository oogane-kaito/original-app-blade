@props([
    'src' => null,
    'alt' => '',
    'fallback' => null,
    'size' => 'md'
])

@php
$sizes = [
    'sm' => 'h-8 w-8',
    'md' => 'h-10 w-10',
    'lg' => 'h-12 w-12',
    'xl' => 'h-16 w-16'
];
$sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->merge(['class' => 'relative flex shrink-0 overflow-hidden rounded-full ' . $sizeClass]) }}>
    @if($src)
        <img 
            src="{{ $src }}" 
            alt="{{ $alt }}"
            class="aspect-square h-full w-full object-cover"
        />
    @else
        <div class="flex h-full w-full items-center justify-center rounded-full bg-muted">
            @if($fallback)
                <span class="text-sm font-medium text-muted-foreground">{{ $fallback }}</span>
            @else
                <svg class="h-4 w-4 text-muted-foreground" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
            @endif
        </div>
    @endif
</div>