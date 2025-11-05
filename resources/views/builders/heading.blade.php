@props([
    'priority' => 'h1',
])

@php

    $priority = $heading->getPriority() ?? $priority;
    
    $classes = Arr::toCssClasses([
        match ($priority) {
            'h1' => 'text-3xl',
            'h2' => 'text-2xl',
            'h3' => 'text-xl',
            default => 'text-3xl',
        },
        // match ($color) {
        //     'gray' => 'text-white',
        //     default => null,
        // },
    ]);
@endphp

<div class="col-span-full flex items-center justify-between">
    <div>
        <{{ $priority }} class="{{ $classes }} font-bold text-gray-900">{{ $heading->getTitle() }}</{!! $priority !!}>
        @if ($description = $heading->getDescription())
        <p class="text-gray-500 mt-2">{!! $description !!}</p>
        @endif
    </div>
    @if ($actions = $heading->getActions())
    <div class="flex gap-2">
        @foreach ($actions as $action)
        @if ($action->isVisible())
        {!! $action->render() !!}
        @endif
        @endforeach
    </div>
    @endif
</div>
