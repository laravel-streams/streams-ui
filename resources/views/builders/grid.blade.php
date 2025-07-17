@php

    $classes = Arr::toCssClasses([
        'grid gap-4',
        match ($grid->isDisabled()) {
            true => 'opacity-40 pointer-events-none',
            default => '',
        },
        match ($grid->getColumns()['default'] ?? 3) {
            1 => 'grid-cols-1',
            2 => 'grid-cols-2',
            3 => 'grid-cols-3',
            4 => 'grid-cols-4',
            5 => 'grid-cols-5',
            6 => 'grid-cols-6',
            7 => 'grid-cols-7',
            8 => 'grid-cols-8',
            9 => 'grid-cols-9',
            10 => 'grid-cols-10',
            11 => 'grid-cols-11',
            12 => 'grid-cols-12',
            default => null,
        },
    ]);
@endphp

<div {{ $attributes->class([
    $classes,
]) }}>

    {{-- Section Header --}}
    {{-- <div class="flex flex-col space-y-2"> --}}

        {{-- Heading --}}
        {{-- @if ($heading = $section->getHeading())
        @if ($url = $section->getUrl())
            <h2 class="">
                <a href="{{ $url }}" class="text-xl font-semibold underline">{{ __($heading) }}</a>
            </h2>
        @else
            <h2 class="text-xl font-semibold">{{ __($heading) }}</h2>
        @endif
        @endif --}}

        {{-- Description --}}
        {{-- @if ($description = $section->getDescription())
            <p class="">{{ __($description) }}</p>
        @endif --}}

    {{-- </div> --}}
    {{-- EOF Section Header --}}

    {{-- Components --}}
    @foreach ($grid->getComponents() as $component)
    {{ $component }}
    @endforeach
</div>
