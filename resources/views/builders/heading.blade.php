@props([
    'priority' => 'h1',
])

@php
    $classes = Arr::toCssClasses([
        match ($priority) {
            'h1' => 'text-3xl',
            default => '',
        },
        // match ($color) {
        //     'gray' => 'text-white',
        //     default => null,
        // },
    ]);
@endphp

<div class="col-span-full">
    <{{ $priority }} class="{{ $classes }} font-bold text-gray-900">{{ $heading->getTitle() }}</{{ $priority }}>
    {{-- @if (isset($description) && $description)
    <p class="text-gray-500 mt-2">{{ $description }}</p>
    @endif --}}
</div>
