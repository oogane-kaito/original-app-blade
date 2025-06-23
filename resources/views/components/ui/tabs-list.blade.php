@props(['orientation' => 'horizontal'])

@php
$orientationClass = $orientation === 'vertical' 
    ? 'flex-col h-auto' 
    : 'flex-row h-10';
@endphp

<div {{ $attributes->merge(['class' => 'inline-flex items-center justify-center rounded-md bg-muted p-1 text-muted-foreground ' . $orientationClass]) }}>
    {{ $slot }}
</div>