@php

    $classes = Arr::toCssClasses([
        '',
        match ($section->isDisabled()) {
            true => 'opacity-60 pointer-events-none',
            default => '',
        },
        // match ($color) {
        //     'gray' => 'text-white',
        //     default => null,
        // },
    ]);
@endphp
<div {{ $attributes->class([
    'flex flex-col',
    $classes,
]) }}>

    {{-- Section Header --}}
    <div class="flex flex-col space-y-2">

        {{-- Heading --}}
        @if ($heading = $section->getHeading())
        @if ($url = $section->getUrl())
            <h2 class="">
                <a href="{{ $url }}" class="text-xl font-semibold underline">{{ __($heading) }}</a>
            </h2>
        @else
            <h2 class="text-xl font-semibold">{{ __($heading) }}</h2>
        @endif
        @endif

        {{-- Description --}}
        @if ($description = $section->getDescription())
            <p class="">{{ __($description) }}</p>
        @endif

    </div>
    {{-- EOF Section Header --}}

    {{-- Components --}}
    @foreach ($section->getComponents() as $component)
    {{ $component }}
    @endforeach
</div>
