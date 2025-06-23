@props(['value'])

<button 
    x-on:click="activeTab = '{{ $value }}'"
    :class="activeTab === '{{ $value }}' ? 'bg-background text-foreground shadow-sm' : ''"
    {{ $attributes->merge(['class' => 'inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50']) }}
>
    {{ $slot }}
</button>
