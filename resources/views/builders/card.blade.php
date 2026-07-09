@php

    $columnSpan = $getColumnSpan();
    $borderRadius = $card->getBorderRadius() ?? 'lg';

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
        match ($borderRadius) {
            default => "rounded-{$borderRadius}",
        },
    ]);

    $heading = $card->getHeading();
    $actions = $card->getActions();
    $description = $card->getDescription();
@endphp
<div {{
    $attributes
        ->merge($card->getHtmlAttributes())
        ->class([
            'flex flex-col shadow-md bg-white',
            'col-[--col-span-default]' => $columnSpan['default'] ?? null,
            'sm:col-[--col-span-sm]' => $columnSpan['sm'] ?? null,
            'md:col-[--col-span-md]' => $columnSpan['md'] ?? null,
            'lg:col-[--col-span-lg]' => $columnSpan['lg'] ?? null,
            'xl:col-[--col-span-xl]' => $columnSpan['xl'] ?? null,
            '2xl:col-[--col-span-2xl]' => $columnSpan['2xl'] ?? null,
            $classes,
        ])
        ->style([
            "--col-span-default: {$getSpanValue($columnSpan['default'])}" => $columnSpan['default'] ?? null,
            "--col-span-sm: {$getSpanValue($columnSpan['sm'])}" => $columnSpan['sm'] ?? null,
            "--col-span-md: {$getSpanValue($columnSpan['md'])}" => $columnSpan['md'] ?? null,
            "--col-span-lg: {$getSpanValue($columnSpan['lg'])}" => $columnSpan['lg'] ?? null,
            "--col-span-xl: {$getSpanValue($columnSpan['xl'])}" => $columnSpan['xl'] ?? null,
            "--col-span-2xl: {$getSpanValue($columnSpan['2xl'])}" => $columnSpan['2xl'] ?? null,
        ])
}}>

    {{-- Card Heading --}}
    @if ($heading || $description || $actions)
    <div class="flex items-center justify-between heading py-4 px-6 border-b border-black/10">
        <div class="flex flex-col">
            @if ($heading)
                @if ($url = $card->getUrl())
                    <h2 class="text-xl font-semibold">
                        <a href="{{ $url }}" class="underline">{{ __($heading) }}</a>
                    </h2>
                @else
                    <h2 class="text-xl font-semibold">{{ __($heading) }}</h2>
                @endif
            @endif
            @if ($description)
                <p>{!! __($description) !!}</p>
            @endif
        </div>
        
        @if ($actions)
            <div class="flex items-center space-x-2">
                @foreach ($actions as $action)
                @if ($action->isVisible())
                {!! $action->render() !!}
                @endif
                @endforeach
            </div>
        @endif
    </div>
    @endif
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
