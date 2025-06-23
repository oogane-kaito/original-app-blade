@props([
    'name' => '',
    'disabled' => false,
    'placeholder' => 'Select an option...',
    'class' => '', // 追加
])

<div class="relative">
    <select 
        name="{{ $name }}"
        @if($disabled) disabled @endif
        {{ $attributes->merge(['class' => 'flex h-10 w-full items-center justify-between rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 appearance-none ' . $class]) }} 
    >
        @if($placeholder)
            <option value="" disabled selected>{{ $placeholder }}</option>
        @endif
        {{ $slot }}
    </select>
    <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
        <svg class="h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>
</div>