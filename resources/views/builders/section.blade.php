@php

    $classes = Arr::toCssClasses([
        '',
        match ($section->isDisabled()) {
            true => 'opacity-40 pointer-events-none',
            default => '',
        },
        // match ($color) {
        //     'gray' => 'text-white',
        //     default => null,
        // },
    ]);
@endphp
<div {{ $attributes->merge($section->getHtmlAttributes())->class([
    'flex flex-col',
    $classes,
]) }}>

    {{-- Section Heading --}}
    <div class="flex items-center justify-between mb-4 heading">
        <div class="flex flex-col">
            @if ($heading = $section->getHeading())
                @if ($url = $section->getUrl())
                    <h2 class="font-semibold">
                        <a href="{{ $url }}" class="text-xl underline">{!! __($heading) !!}</a>
                    </h2>
                @else
                    <h2 class="text-xl font-semibold">{!! __($heading) !!}</h2>
                @endif
            @endif
            @if ($description = $section->getDescription())
                <p class="">{{ __($description) }}</p>
            @endif
        </div>
        {{-- Actions --}}
        @if ($actions = $section->getActions())
            <div class="flex items-center space-x-2">
                @foreach ($actions as $action)
                    {!! $action->render() !!}
                @endforeach
            </div>
        @endif
    </div>
    {{-- EOF Section Heading --}}

    {{-- Components --}}
    @if ($components = $section->getComponents())
    <div class="p-6 overflow-auto">
    @foreach ($components as $component)
    {{ $component }}
    @endforeach
    </div>
    @endif
</div>
