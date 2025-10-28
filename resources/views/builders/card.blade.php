@php

    $columnSpan = $getColumnSpan();

    if (! is_array($columnSpan)) {
        $columnSpan = [
            'default' => $columnSpan,
        ];
    }

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
<div {{ $attributes->merge($card->getHtmlAttributes())->class([
    'flex flex-col rounded-lg shadow-md bg-white',
    $classes,
]) }}>

    {{-- Card Heading --}}
    <div class="flex items-center justify-between heading p-6 border-b border-black/10">
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
        
        @if ($actions = $card->getActions())
            <div class="flex items-center space-x-2">
                @foreach ($actions as $action)
                @if ($action->isVisible())
                {!! $action->render() !!}
                @endif
                @endforeach
            </div>
        @endif
    </div>
    {{-- EOF Card Heading --}}

    {{-- Components --}}
    @if ($components = $card->getComponents())    
    <div class="p-6 overflow-auto">
    @foreach ($components as $component)
    {{ $component }}
    @endforeach
    </div>
    @endif
</div>
