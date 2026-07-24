@php

    $columnSpan = $getColumnSpan();

    if (! is_array($columnSpan)) {
        $columnSpan = [
            'default' => $columnSpan,
        ];
    }

    $getSpanValue = function ($span): string {
        
        if ($span === 'full') {
            return '1 / -1';
        }

        return "span {$span} / span {$span}";
    };

    $columns = $grid->getColumns();

    if (! is_array($columns)) {
        $columns = [
            'default' => $columns,
        ];
    }

    $classes = Arr::toCssClasses([
        'grid items-start gap-4 w-full',
        match ($grid->isDisabled()) {
            true => 'opacity-40 pointer-events-none',
            default => '',
        },
        match ($columns['default'] ?? 3) {
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
        match ($columns['sm'] ?? null) {
            1 => 'sm:grid-cols-1',
            2 => 'sm:grid-cols-2',
            3 => 'sm:grid-cols-3',
            4 => 'sm:grid-cols-4',
            5 => 'sm:grid-cols-5',
            6 => 'sm:grid-cols-6',
            7 => 'sm:grid-cols-7',
            8 => 'sm:grid-cols-8',
            9 => 'sm:grid-cols-9',
            10 => 'sm:grid-cols-10',
            11 => 'sm:grid-cols-11',
            12 => 'sm:grid-cols-12',
            default => null,
        },
        match ($columns['md'] ?? null) {
            1 => 'md:grid-cols-1',
            2 => 'md:grid-cols-2',
            3 => 'md:grid-cols-3',
            4 => 'md:grid-cols-4',
            5 => 'md:grid-cols-5',
            6 => 'md:grid-cols-6',
            7 => 'md:grid-cols-7',
            8 => 'md:grid-cols-8',
            9 => 'md:grid-cols-9',
            10 => 'md:grid-cols-10',
            11 => 'md:grid-cols-11',
            12 => 'md:grid-cols-12',
            default => null,
        },
        match ($columns['lg'] ?? null) {
            1 => 'lg:grid-cols-1',
            2 => 'lg:grid-cols-2',
            3 => 'lg:grid-cols-3',
            4 => 'lg:grid-cols-4',
            5 => 'lg:grid-cols-5',
            6 => 'lg:grid-cols-6',
            7 => 'lg:grid-cols-7',
            8 => 'lg:grid-cols-8',
            9 => 'lg:grid-cols-9',
            10 => 'lg:grid-cols-10',
            11 => 'lg:grid-cols-11',
            12 => 'lg:grid-cols-12',
            default => null,
        },
        match ($columns['xl'] ?? null) {
            1 => 'xl:grid-cols-1',
            2 => 'xl:grid-cols-2',
            3 => 'xl:grid-cols-3',
            4 => 'xl:grid-cols-4',
            5 => 'xl:grid-cols-5',
            6 => 'xl:grid-cols-6',
            7 => 'xl:grid-cols-7',
            8 => 'xl:grid-cols-8',
            9 => 'xl:grid-cols-9',
            10 => 'xl:grid-cols-10',
            11 => 'xl:grid-cols-11',
            12 => 'xl:grid-cols-12',
            default => null,
        },
        match ($columns['2xl'] ?? null) {
            1 => '2xl:grid-cols-1',
            2 => '2xl:grid-cols-2',
            3 => '2xl:grid-cols-3',
            4 => '2xl:grid-cols-4',
            5 => '2xl:grid-cols-5',
            6 => '2xl:grid-cols-6',
            7 => '2xl:grid-cols-7',
            8 => '2xl:grid-cols-8',
            9 => '2xl:grid-cols-9',
            10 => '2xl:grid-cols-10',
            11 => '2xl:grid-cols-11',
            12 => '2xl:grid-cols-12',
            default => null,
        },
    ]);
@endphp

@php
    // Only apply column-span vars when explicitly configured. A layout Grid
    // defaults to span 1; emitting --col-span-* would inherit to children and
    // override cards/containers that reference col-[--col-span-*] without a local var.
    $applyColumnSpan = $grid->hasColumnSpan();
@endphp

<div {{
    $attributes
        ->merge($grid->getHtmlAttributes())
        ->class([
            $classes,
            'col-[--col-span-default]' => $applyColumnSpan && ($columnSpan['default'] ?? null),
            'sm:col-[--col-span-sm]' => $applyColumnSpan && ($columnSpan['sm'] ?? null),
            'md:col-[--col-span-md]' => $applyColumnSpan && ($columnSpan['md'] ?? null),
            'lg:col-[--col-span-lg]' => $applyColumnSpan && ($columnSpan['lg'] ?? null),
            'xl:col-[--col-span-xl]' => $applyColumnSpan && ($columnSpan['xl'] ?? null),
            '2xl:col-[--col-span-2xl]' => $applyColumnSpan && ($columnSpan['2xl'] ?? null),
        ])
        ->style([
            "--col-span-default: {$getSpanValue($columnSpan['default'])}" => $applyColumnSpan && ($columnSpan['default'] ?? null),
            "--col-span-sm: {$getSpanValue($columnSpan['sm'])}" => $applyColumnSpan && ($columnSpan['sm'] ?? null),
            "--col-span-md: {$getSpanValue($columnSpan['md'])}" => $applyColumnSpan && ($columnSpan['md'] ?? null),
            "--col-span-lg: {$getSpanValue($columnSpan['lg'])}" => $applyColumnSpan && ($columnSpan['lg'] ?? null),
            "--col-span-xl: {$getSpanValue($columnSpan['xl'])}" => $applyColumnSpan && ($columnSpan['xl'] ?? null),
            "--col-span-2xl: {$getSpanValue($columnSpan['2xl'])}" => $applyColumnSpan && ($columnSpan['2xl'] ?? null),
        ])
}}>

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
