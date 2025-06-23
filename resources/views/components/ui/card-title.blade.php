@props(['tag' => 'h3'])

<{{ $tag }} {{ $attributes->merge(['class' => 'text-2xl font-semibold leading-none tracking-tight']) }}>
    {{ $slot }}
</{{ $tag }}>