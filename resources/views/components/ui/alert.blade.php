@props(['variant' => 'default'])

@php
$variants = [
    'default' => 'bg-background text-foreground',
    'destructive' => 'border-destructive/50 text-destructive dark:border-destructive [&>svg]:text-destructive',
];

$variantClass = $variants[$variant] ?? $variants['default'];
@endphp

<div {{ $attributes->merge(['class' => 'relative w-full rounded-lg border p-4 [&>svg~*]:pl-7 [&>svg+div]:translate-y-[-3px] [&>svg]:absolute [&>svg]:left-4 [&>svg]:top-4 [&>svg]:text-foreground ' . $variantClass]) }}>
    {{ $slot }}
</div>
