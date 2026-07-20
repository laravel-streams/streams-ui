@props([
    'priority' => 'h1',
])

@php

    $icon = $heading->getIcon();
    $iconPosition = 'before'; //$heading->getIconPosition() ?? 'before';
    $iconSize = 'lg'; //$heading->getIconSize() ?? 'md';

    $priority = $heading->getPriority() ?? $priority;
    
    $classes = Arr::toCssClasses([
        match ($priority) {
            'h1' => 'text-3xl',
            'h2' => 'text-2xl',
            'h3' => 'text-xl',
            'h4' => 'text-lg',
            default => 'text-3xl',
        },
        // match ($color) {
        //     'gray' => 'text-white',
        //     default => null,
        // },
    ]);

    $iconClasses = Arr::toCssClasses([
        '',
        match ($iconSize) {
            'sm' => 'h-4 w-4',
            'md' => 'h-5 w-5',
            'lg' => 'h-6 w-6',
            default => match ($priority) {
            'h1' => 'h-6 w-6',
            'h2' => 'h-5 w-5',
            'h3' => 'h-4 w-4',
            default => $iconSize,
        },
        },
    ]);
@endphp

<div class="col-span-full flex items-center justify-between">
    <div class="flex items-center space-x-3">
        @if ($icon && $iconPosition === 'before')
        <x-ui::icon
            :attributes="
                new \Illuminate\View\ComponentAttributeBag([
                    'icon' => $icon,
                    'class' => $iconClasses,
                ])"
        />
        @endif
        <div>
            <{{ $priority }} {{ $heading->getHtmlAttributeBag()->class([$classes . ' font-bold text-gray-900']) }}>{{ $heading->getTitle() }}</{!! $priority !!}>
            @if ($description = $heading->getDescription())
            <p class="opacity-90 mt-2">{!! $description !!}</p>
            @endif
        </div>
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
