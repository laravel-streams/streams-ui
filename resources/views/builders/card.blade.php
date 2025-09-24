@php

    $classes = Arr::toCssClasses([
        '',
        match ($card->isDisabled()) {
            true => 'opacity-40 pointer-events-none',
            default => '',
        },
        // match ($color) {
        //     'gray' => 'text-white',
        //     default => null,
        // },
    ]);
@endphp
<div {{ $attributes->class([
    'flex flex-col rounded-lg shadow-md bg-white p-6',
    $classes,
]) }}>

    {{-- Card Heading --}}
    <div class="flex items-center justify-between mb-4 heading">
        <div class="flex flex-col">
            @if ($heading = $card->getHeading())
                @if ($url = $card->getUrl())
                    <h2 class="text-xl font-semibold">
                        <a href="{{ $url }}" class="underline">{{ __($heading) }}</a>
                    </h2>
                @else
                    <h2 class="text-xl font-semibold">{{ __($heading) }}</h2>
                @endif
            @endif
            @if ($description = $card->getDescription())
                <p class="">{{ __($description) }}</p>
            @endif
        </div>
        {{-- Actions --}}
        @if ($actions = $card->getActions())
            <div class="flex items-center space-x-2">
                @foreach ($actions as $action)
                    {!! $action->render() !!}
                @endforeach
            </div>
        @endif
    </div>
    {{-- EOF Card Heading --}}

    {{-- Components --}}
    @foreach ($card->getComponents() as $component)
    {{ $component }}
    @endforeach
</div>
