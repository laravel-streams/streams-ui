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

    $spacingClasses = match ($card->getSpacing() ?? 'sm') {
        'none' => '',
        'xs' => 'space-y-2',
        'sm' => 'space-y-4',
        'md' => 'space-y-6',
        'lg' => 'space-y-8',
        'xl' => 'space-y-10',
        '2xl' => 'space-y-12',
        default => 'space-y-4',
    };

    $heading = $card->getHeading();
    $actions = $card->getActions();
    $description = $card->getDescription();

    // inset(false) flushes content only; heading keeps the default inset.
    $inset = $card->getInset();
    $contentInsetClass = $card->getInsetPaddingClass(default: 'p-6');

    if ($inset === false || $inset === 'none') {
        $headingInsetXClass = 'px-6';
        $headingInsetYClass = 'py-4';
    } else {
        $headingInsetXClass = $card->getInsetPaddingClass('px', 'px-6');
        $headingInsetYClass = $card->getInsetPaddingClass('py', 'py-4');
    }
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
            $spacingClasses,
            $classes,
        ])
}}>

    {{-- Card Heading --}}
    @if ($heading || $description || $actions)
    <div @class(['flex items-center justify-between heading border-b border-black/10', $headingInsetXClass, $headingInsetYClass])>
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
    <div @class(['overflow-auto', $contentInsetClass])>
    @foreach ($components as $component)
    {{ $component }}
    @endforeach
    </div>
    @endif
</div>
