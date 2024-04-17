@props([
    'badge' => null,
    'badgeColor' => 'primary',
    'borderRadius' => null,
    'color' => 'primary',
    'size' => 'md',
    'disabled' => false,
    'form' => null,
    'grouped' => false,
    'href' => null,
    'icon' => null,
    'iconPosition' => 'before',
    'iconSize' => null,
    'keyBindings' => null,
    'labeledFrom' => null,
    'labelSrOnly' => false,
    'loadingIndicator' => true,
    'outlined' => false,
    'target' => null,
    'tooltip' => null,
    'tag' => 'button',
    'type' => 'button',
    'style' => 'button',
])
@php
    $actionClasses = ['relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75'];

    $actionClasses[] = Arr::toCssClasses(
        match ($style) {
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
                    null => [
                        'bg-gray-500 text-white hover:bg-gray-600',
                    ],
                    default => [
                        'bg-' . $color . '-500 text-white hover:bg-' . $color . '-600',
                    ],
                },
            ],
            'link' => [
                ...match ($color) {
                    null => [],
                    default => [
                        'text-' . $color . '-500 hover:text-' . $color . '-600',
                    ],
                },
            ],
            default => '',
        }
    );

    $actionClasses[] = Arr::toCssClasses([
        ...[
            'relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2',
            'pointer-events-none opacity-70' => $disabled,
            'flex-1' => $grouped,
            // 'rounded-lg' => ! $grouped,
            match ($color) {
                'gray' => '',
                default => '',
            },
            is_string($color) ? "{$color}" : null,
            match ($size) {
                'xs' => 'gap-1 px-2 py-1.5',
                'sm' => 'gap-1 px-2.5 py-1.5',
                'md' => 'gap-1.5 px-3 py-2',
                'lg' => 'gap-1.5 px-3.5 py-2.5',
                'xl' => 'gap-1.5 px-4 py-3',
                default => $size,
            },
            'hidden' => $labeledFrom,
            match ($labeledFrom) {
                'sm' => 'sm:inline-grid',
                'md' => 'md:inline-grid',
                'lg' => 'lg:inline-grid',
                'xl' => 'xl:inline-grid',
                '2xl' => '2xl:inline-grid',
                default => 'inline-grid',
            },
        ],
        ...(
            $outlined ?
                [
                    'ring-1',
                    match ($color) {
                        'gray' => 'text-gray-950 ring-gray-300 hover:bg-gray-400/10 focus-visible:ring-gray-400/40',
                        default => 'text-gray-600 ring-gray-600 hover:bg-gray-400/10',
                    },
                ] : []
        ),
    ]);

    $buttonStyles = Arr::toCssStyles([
        // \Filament\Support\get_color_css_variables(
        //     $color,
        //     shades: [400, 500, 600],
        // ) => $color !== 'gray',
    ]);

    $iconClasses = Arr::toCssClasses([
        '',
        match ($iconSize) {
            'sm' => 'h-4 w-4',
            'md' => 'h-5 w-5',
            'lg' => 'h-6 w-6',
            default => $iconSize,
        },
        match ($color) {
            'gray' => 'text-gray-400',
            default => null,
        },
    ]);

    $badgeContainerClasses = 'absolute -top-1 start-full z-[1] -ms-1 w-max -translate-x-1/2 rounded-md bg-white rtl:translate-x-1/2';

    $wireTarget = $loadingIndicator ? $attributes->whereStartsWith(['wire:target', 'wire:click'])->filter(fn ($value): bool => filled($value))->first() : null;

    $hasTooltip = filled($tooltip);
@endphp

<{{ $tag }}
    @if (($keyBindings || $hasTooltip))
        x-data="{}"
    @endif
    @if ($keyBindings)
        x-mousetrap.{{ collect($keyBindings)->map(fn (string $keyBinding): string => str_replace('+', '-', $keyBinding))->implode('.') }}
    @endif
    @if ($hasTooltip)
        x-tooltip="{
            content: @js($tooltip),
            theme: $store.theme,
        }"
    @endif
    {{
        $attributes
            ->merge([
                'href' => $href,
                'disabled' => $disabled,
                'wire:loading.attr' => 'disabled',
                'type' => $tag == 'button' ? $type : false,
            ], escape: false)
            ->class([implode(' ', $actionClasses)])
            ->style([$buttonStyles])
    }}
>
    @if ($icon && $iconPosition === 'before')
    <x-ui::icon
        :attributes="
            new \Illuminate\View\ComponentAttributeBag([
                'icon' => $icon,
            ])
        "
    />
    @endif

    <span class="{{ Arr::toCssClasses([
        'ui-button-label',
        'sr-only' => $labelSrOnly,
    ]) }}">
        {{ $slot }}
    </span>

    {{-- @if ($hasFileUploadLoadingIndicator)
        <span x-show="isUploadingFile" x-cloak>
            {{ __('ui::components/button.messages.uploading_file') }}
        </span>
    @endif --}}

    @if ($icon && $iconPosition === 'after')
    <x-ui::icon
        :attributes="
            \Filament\Support\prepare_inherited_attributes(
                new \Illuminate\View\ComponentAttributeBag([
                    'icon' => $icon,
                ])
            )->class([$iconClasses])
        "
    />
    @endif

    {{-- @if (filled($badge))
        <div class="{{ $badgeContainerClasses }}">
            <x-ui::badge :color="$badgeColor" size="xs">
                {{ $badge }}
            </x-ui::badge>
        </div>
    @endif --}}
</{{ $tag }}>
