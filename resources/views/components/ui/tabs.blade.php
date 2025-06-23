@props([
    'defaultValue' => null,
    'orientation' => 'horizontal'
])

<div 
    x-data="{ activeTab: '{{ $defaultValue }}' }"
    {{ $attributes->merge(['class' => 'w-full']) }}
    data-orientation="{{ $orientation }}"
>
    {{ $slot }}
</div>
