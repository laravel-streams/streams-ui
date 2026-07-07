@props([
    'badge' => null,
    'badgeColor' => 'primary',
    'borderRadius' => null,
    'color' => null,
    'size' => 'sm',
    'disabled' => false,
    'form' => null,
    'grouped' => false,
    'href' => null,
    'openInNewTab' => false,
    'icon' => null,
    'iconPosition' => 'after',
    'iconSize' => null,
    'keyBindings' => null,
    'labeledFrom' => null,
    'labelSrOnly' => false,
    'loadingIndicator' => false,
    'loadingText' => null,
    'outlined' => false,
    'target' => null,
    'tooltip' => null,
    'tooltipPlacement' => 'top',
    'tag' => null,
    'type' => 'button',
    'style' => 'button',
])
@php
    $tag = $tag ?: ($href ? 'a' : 'button');

    $classes = Arr::toCssClasses([
        // Base classes
        'relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75',
        
        // Style-specific classes
        ...match ($style) {
            'button' => [
                'shadow-sm' => ! $grouped,
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
                ...match ($color) {
                    'black' => [
                        'bg-black text-white hover:bg-gray-700',
                    ],
                    'light' => [
                        'bg-gray-200 text-gray-700 hover:bg-gray-300',
                    ],
                    'secondary' => [
                        'border border-black bg-white hover:bg-black hover:text-white',
                    ],
                    default => [
                        'bg-custom-500 text-white hover:bg-custom-600',
                    ],
                },
            ],
            'link' => [
                ...match ($color) {
                    null => [],
                    default => [
                        'text-custom-500',
                    ],
                },
            ],
            default => [],
        },
        
        // State classes
        'pointer-events-none opacity-70' => $disabled,
        'flex-1' => $grouped,
        
        // Color classes
        match ($color) {
            'gray' => '',
            default => '',
        },
        is_string($color) ? "{$color}" : null,
        
        // Size classes
        match ($size) {
            'xs' => '_gap-1 px-3 py-1.5',
            'sm' => '_gap-1 px-4 py-1.5',
            'md' => '_gap-1.5 px-6 py-2',
            'lg' => '_gap-1.5 px-6 py-2.5',
            'xl' => '_gap-1.5 px-7 py-3',
            default => $size,
        },
        
        // Responsive visibility
        'hidden' => $labeledFrom,
        match ($labeledFrom) {
            'sm' => 'sm:inline-grid',
            'md' => 'md:inline-grid',
            'lg' => 'lg:inline-grid',
            'xl' => 'xl:inline-grid',
            '2xl' => '2xl:inline-grid',
            default => 'inline-grid',
        },
        
        // Outlined styles
        ...($outlined ? [
            'ring-1',
            match ($color) {
                'gray' => 'text-gray-950 ring-gray-300 hover:bg-gray-400/10 focus-visible:ring-gray-400/40',
                default => 'text-gray-600 ring-gray-600 hover:bg-gray-400/10',
            },
        ] : []),
    ]);

    $actionStyles = Arr::toCssStyles([
        \Streams\Ui\Support\Facades\Colors::colorVariables(
            $color,
            shades: [400, 500, 600],
        ),
    ]);

    $iconClasses = Arr::toCssClasses([
        '',
        match ($iconSize ?: $size) {
            'sm' => 'h-5 w-5',
            'md' => 'h-6 w-6',
            'lg' => 'h-7 w-7',
            default => $iconSize,
        },
        match ($color) {
            'gray' => 'text-white',
            default => null,
        },
    ]);

    $badgeContainerClasses = 'absolute -top-1 start-full z-[1] -ms-1 w-max -translate-x-1/2 rounded-md bg-white rtl:translate-x-1/2';

    $hasTooltip = filled($tooltip);

    // Determine loading indicator icon
    $loadingIcon = is_string($loadingIndicator) ? $loadingIndicator : 'heroicon-o-arrow-path';
    $showLoadingIndicator = (bool) $loadingIndicator;
    $hasLoadingText = filled($loadingText);
    $hasLoadingUi = $showLoadingIndicator || $hasLoadingText;

    $wireTarget = $hasLoadingUi
        ? $attributes->whereStartsWith(['wire:target', 'wire:click'])->filter(fn ($value): bool => filled($value))->first()
        : null;
@endphp

<{{ $tag }}
    @if (($keyBindings || $hasTooltip))
        x-data="{}"
    @endif
    @if ($keyBindings)
        x-mousetrap.{{ collect($keyBindings)->map(fn (string $keyBinding): string => str_replace('+', '-', $keyBinding))->implode('.') }}
    @endif
    @if ($hasTooltip)
        x-tooltip.placement.{{ $tooltipPlacement }}="{
            content: @js($tooltip),
            {{-- theme: $store.theme, --}}
        }"
    @endif
    {!! $attributes
        ->merge([
            'href' => $href,
            'target' => $openInNewTab ? '_blank' : '_self',
            'disabled' => $disabled,
            'wire:loading.attr' => 'disabled',
            'type' => $tag == 'button' ? $type : false,
        ], escape: false)
        ->class([$classes])
        ->style([$actionStyles]) !!}
>
    @if ($hasLoadingUi)
        {{-- Loading layer: icon only, text only, or icon + text --}}
        <span
            class="absolute inset-0 flex items-center justify-center gap-2 invisible"
            @if ($wireTarget)
                wire:loading.delay.class.remove="invisible"
                wire:target="{{ $wireTarget }}"
            @else
                wire:loading.delay.class.remove="invisible"
            @endif
        >
            @if ($showLoadingIndicator)
                <x-ui::icon
                    :attributes="
                        new \Illuminate\View\ComponentAttributeBag([
                            'icon' => $loadingIcon,
                            'class' => Arr::toCssClasses([
                                $iconClasses,
                                'animate-spin',
                                $hasLoadingText ? 'shrink-0' : null,
                            ]),
                        ])
                    "
                />
            @endif
            @if ($hasLoadingText)
                <span class="{{ $showLoadingIndicator ? '' : 'text-center' }}">{{ $loadingText }}</span>
            @endif
        </span>
    @endif

    {{-- Default label (hidden while loading when any loading UI is active) --}}
    <span
        @if ($hasLoadingUi)
            @if ($wireTarget)
                wire:loading.delay.class="invisible"
                wire:target="{{ $wireTarget }}"
            @else
                wire:loading.delay.class="invisible"
            @endif
        @endif
        class="flex items-center"
    >
        @if ($icon && $iconPosition === 'before')
        <x-ui::icon
            :attributes="
                new \Illuminate\View\ComponentAttributeBag([
                    'icon' => $icon,
                    'class' => $iconClasses,
                ])
            "
        />
        @endif

        @if (!$slot->isEmpty())
        <span class="{{ Arr::toCssClasses([
            'sr-only' => $labelSrOnly,
        ]) }}">
            {!! $slot !!}
        </span>
        @endif

        @if ($icon && $iconPosition === 'after')
        <x-ui::icon
            :attributes="
                new \Illuminate\View\ComponentAttributeBag([
                    'icon' => $icon,
                    'class' => $iconClasses,
                ])
            "
        />
        @endif
    </span>

    {{-- @if ($hasFileUploadLoadingIndicator)
        <span x-show="isUploadingFile" x-cloak>
            {{ __('ui::components/button.messages.uploading_file') }}
        </span>
    @endif --}}

    {{-- @if (filled($badge))
        <div class="{{ $badgeContainerClasses }}">
            <x-ui::badge :color="$badgeColor" size="xs">
                {{ $badge }}
            </x-ui::badge>
        </div>
    @endif --}}
</{{ $tag }}>
