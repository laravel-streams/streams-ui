@props([
    'actions' => [],
    'description' => null,
    'heading',
    'icon',
    'borderRadius' => 'none',
    'components' => [],
])

<?php

    $classes = Arr::toCssClasses([
        'p-6',
        match ($color ?? null) {
            'gray' => 'bg-gray-100',
            'white' => 'bg-white',
            'black' => 'bg-black',
            default => null,
        },
        match ($borderRadius) {
            true => 'rounded',
            'sm' => 'rounded-sm',
            'md' => 'rounded-md',
            'lg' => 'rounded-lg',
            'xl' => 'rounded-xl',
            '2xl' => 'rounded-2xl',
            '3xl' => 'rounded-3xl',
            'full' => 'rounded-full',
            default => $borderRadius,
        },
    ]);

?>

<div
    {!! $attributes
        ->merge([
            // 'wire:loading.attr' => 'disabled',
        ], escape: false)
        ->class([$classes])
        // ->style([$actionStyles])
    !!}
>

    <div class="mx-auto grid max-w-lg justify-items-center text-center">

        @if ($icon)
        <div class="mb-4 rounded-full bg-gray-100 p-3">
            <x-ui::icon :icon="$icon" class=" h-6 w-6" />
        </div>
        @endif

        @if ($heading)
        <x-ui::empty-state.heading>
            {{ $heading }}
        </x-ui::empty-state.heading>
        @endif

        @if ($description)
        <x-ui::empty-state.description class="mt-1">
            {{ $description }}
        </x-ui::empty-state.description>
        @endif

        @if ($actions)
        <div class="mt-6">
            @foreach ($actions as $action)
            {!! $action->render() !!}
            @endforeach
        </div>
        @endif

        @if ($components)
        @foreach ($components as $component)
        @if (is_string($component))
            @livewire($component)
        @else
            {!! $component->render() !!}
        @endif
        @endforeach
        @endif

    </div>
</div>
