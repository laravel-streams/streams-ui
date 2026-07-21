@props([
    'badge' => null,
    'badgeColor' => 'primary',
    'borderRadius' => null,
    'color' => null,
    'size' => 'md',
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

    $hasSlotLabel = filled(Str::squish((string) $slot));
    $hasVisibleLabel = $hasSlotLabel && ! $labelSrOnly;
    
    $isIconOnly = filled($icon) && ! $hasVisibleLabel;
    $ariaLabel = $labelSrOnly && $hasSlotLabel
        ? Str::squish(strip_tags((string) $slot))
        : null;

    $yPaddingClasses = match ($size) {
        'xs' => 'py-1.5',
        'sm' => 'py-1.5',
        'md' => 'py-2',
        'lg' => 'py-2.5',
        'xl' => 'py-3',
        default => null,
    };

    // Horizontal padding and icon/label gap only when a visible label string exists.
    // Size only chooses the amount; icon-only uses symmetric `p-*` instead.
    $xPaddingClasses = $hasVisibleLabel ? match ($size) {
        'xs' => 'px-3',
        'sm' => 'px-4',
        'md' => 'px-6',
        'lg' => 'px-6',
        'xl' => 'px-7',
        default => null,
    } : null;

    $iconOnlyPaddingClasses = match ($size) {
        'xs' => 'p-1.5',
        'sm' => 'p-1.5',
        'md' => 'p-2',
        'lg' => 'p-2.5',
        'xl' => 'p-3',
        default => null,
    };

    $classes = Arr::toCssClasses([
        // Base classes — outline-none removes the browser default; focus-visible:* restores
        // an accessible keyboard-only ring (no persistent mouse-click focus ring).
        // Avoid grid-flow-col on icon-only: blade whitespace text nodes become extra
        // columns and read as left-side blank space before the icon.
        $isIconOnly
            ? 'relative inline-flex items-center justify-center font-semibold leading-none outline-none transition duration-75'
            : 'relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75',
        'focus-visible:z-10 focus-visible:ring-2 focus-visible:ring-custom-500',

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
                        'bg-black text-white hover:bg-gray-700 focus-visible:ring-gray-700',
                    ],
                    'light' => [
                        'bg-gray-200 text-gray-700 hover:bg-gray-300 focus-visible:ring-gray-400',
                    ],
                    'secondary' => [
                        'border border-black bg-white hover:bg-black hover:text-white focus-visible:ring-gray-700',
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

        // Gap only when a visible label string is present (not size-driven).
        $hasVisibleLabel ? 'gap-1.5' : null,
        $isIconOnly ? $iconOnlyPaddingClasses : $yPaddingClasses,
        (! $isIconOnly) ? $xPaddingClasses : null,

        // Responsive visibility
        'hidden' => $labeledFrom,
        match ($labeledFrom) {
            'sm' => $isIconOnly ? 'sm:inline-flex' : 'sm:inline-grid',
            'md' => $isIconOnly ? 'md:inline-flex' : 'md:inline-grid',
            'lg' => $isIconOnly ? 'lg:inline-flex' : 'lg:inline-grid',
            'xl' => $isIconOnly ? 'xl:inline-flex' : 'xl:inline-grid',
            '2xl' => $isIconOnly ? '2xl:inline-flex' : '2xl:inline-grid',
            // Base display is already set above for icon-only (inline-flex) vs labeled (via inline-grid here).
            default => $isIconOnly ? null : 'inline-grid',
        },

        // Outlined styles
        ...($outlined ? [
            'ring-1',
            match ($color) {
                'gray' => 'text-gray-950 ring-gray-300 hover:bg-gray-400/10 focus-visible:ring-gray-400/40',
                default => 'text-gray-600 ring-gray-600 hover:bg-gray-400/10 focus-visible:ring-custom-500',
            },
        ] : []),
    ]);

    $actionStyles = Arr::toCssStyles([
        \Streams\Ui\Support\Facades\Colors::colorVariables(
            $color,
            shades: [400, 500, 600],
        ),
    ]);

    $iconGapClasses = match ($size) {
        'xs', 'sm' => 'gap-1',
        default => 'gap-1.5',
    };

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
            'aria-label' => $ariaLabel,
        ], escape: false)
        ->class([$classes])
        ->style([$actionStyles]) !!}
>{{--
--}}@if ($isIconOnly && ! $hasLoadingUi)<x-ui::icon
        :attributes="
            new \Illuminate\View\ComponentAttributeBag([
                'icon' => $icon,
                'class' => $iconClasses,
            ])
        "
    />{{--
--}}@else
    @if ($hasLoadingUi)
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
    <span
        @if ($hasLoadingUi)
            @if ($wireTarget)
                wire:loading.delay.class="invisible"
                wire:target="{{ $wireTarget }}"
            @else
                wire:loading.delay.class="invisible"
            @endif
        @endif
        class="{{ Arr::toCssClasses([
            'flex items-center',
            $icon && $hasVisibleLabel ? $iconGapClasses : null,
        ]) }}"
    >{{--
--}}@if ($icon && ($iconPosition === 'before' || ! $hasVisibleLabel))
            <x-ui::icon
                :attributes="
                    new \Illuminate\View\ComponentAttributeBag([
                        'icon' => $icon,
                        'class' => $iconClasses,
                    ])
                "
            />
        @endif
        @if ($hasVisibleLabel)
            <span>{!! $slot !!}</span>
        @endif
        @if ($icon && $iconPosition === 'after' && $hasVisibleLabel)
            <x-ui::icon
                :attributes="
                    new \Illuminate\View\ComponentAttributeBag([
                        'icon' => $icon,
                        'class' => $iconClasses,
                    ])
                "
            />
        @endif{{--
--}}</span>
@endif
    @if (filled($badge))
        <div class="{{ $badgeContainerClasses }}">
            <x-ui::badge :color="$badgeColor" size="xs">
                {{ $badge }}
            </x-ui::badge>
        </div>
    @endif
</{{ $tag }}>
