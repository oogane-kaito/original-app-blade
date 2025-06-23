@props([
    'variant' => 'default',
    'size' => 'default'
])

@php
$variants = [
    'default' => 'border-transparent bg-primary text-primary-foreground hover:bg-primary/80',
    'secondary' => 'border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80',
    'destructive' => 'border-transparent bg-destructive text-destructive-foreground hover:bg-destructive/80',
    'outline' => 'text-foreground border-border bg-transparent',
];

$sizes = [
    'default' => 'px-2.5 py-0.5 text-xs',
    'sm' => 'px-2 py-0.5 text-xs',
    'lg' => 'px-3 py-1 text-sm',
];

$variantClass = $variants[$variant] ?? $variants['default'];
$sizeClass = $sizes[$size] ?? $sizes['default'];
@endphp

<div {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full border font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 ' . $variantClass . ' ' . $sizeClass]) }}>
    {{ $slot }}
</div>