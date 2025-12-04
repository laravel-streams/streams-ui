@props([
    'disabled' => false,
    
    'color' => 'primary',
    
    'href' => null,
    'keyBindings' => null,
    'size' => 'md',
    'tag' => 'div',
    'target' => null,
    'type' => 'button',
    
    'icon' => null,
    'iconSize' => 'sm',
    'iconAlias' => null,
    'iconPosition' => 'before',

    'tooltip' => null,
    'tooltipPosition' => null,
])

@php
    
    $iconClasses = \Illuminate\Support\Arr::toCssClasses([
        'h-4 w-4',
        match ($iconSize) {
            'sm' => 'h-4 w-4',
            'md' => 'h-5 w-5',
            'lg' => 'h-6 w-6',
            default => $iconSize,
        },
        match ($color) {
            'gray' => 'text-gray-400',
            default => 'text-custom-500',
        },
    ]);

    $wireTarget = $attributes->whereStartsWith(['wire:target', 'wire:click'])->filter(fn ($value): bool => filled($value))->first();

    $hasTooltip = filled($tooltip);
@endphp

<{{ $tag }}
    @if ($tag === 'a')
        {{ \Filament\Support\generate_href_html($href, $target === '_blank') }}
    @endif
    @if ($keyBindings || $hasTooltip)
        x-data="{}"
    @endif
    @if ($keyBindings)
        x-mousetrap.global.{{ collect($keyBindings)->map(fn (string $keyBinding): string => str_replace('+', '-', $keyBinding))->implode('.') }}
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
                'disabled' => $tag === 'button' ? $disabled : null,
                'type' => $tag === 'button' ? $type : null,
                'wire:loading.attr' => $tag === 'button' ? 'disabled' : null,
                // 'wire:target' => ($hasLoadingIndicator && $loadingIndicatorTarget) ? $loadingIndicatorTarget : null,
            ], escape: false)
            ->class([
                'flex items-center justify-center gap-x-1 rounded-md text-xs font-medium',
                'pointer-events-none opacity-70' => $disabled,
                match ($size) {
                    'xs' => 'px-0.5 min-w-[theme(spacing.4)] tracking-tighter',
                    'sm' => 'px-1.5 min-w-[theme(spacing.5)] py-0.5 tracking-tight',
                    'md', 'lg', 'xl' => 'px-2 min-w-[theme(spacing.6)] py-1',
                    default => $size,
                },
                match ($color) {
                    'gray' => 'bg-gray-200 text-gray-600',
                    default => 'bg-custom-500 text-white',
                },
            ])
            ->style([
                Arr::toCssStyles([
                    \Streams\Ui\Support\Facades\Colors::colorVariables(
                        $color,
                        shades: [400, 500, 600],
                    ),
                ]) => $color !== 'gray',
            ])
        }}
>
    @if ($iconPosition === 'before')
        @if ($icon)
            <x-ui::icon
                :attributes="
                    \Filament\Support\prepare_inherited_attributes(
                        new \Illuminate\View\ComponentAttributeBag([
                            'alias' => $iconAlias,
                            'icon' => $icon,
                            // 'wire:loading.remove.delay.' . config('filament.livewire_loading_delay', 'default') => $hasLoadingIndicator,
                            // 'wire:target' => $hasLoadingIndicator ? $loadingIndicatorTarget : null,
                        ])
                    )->class([$iconClasses])
                "
            />
        @endif

        {{-- @if ($hasLoadingIndicator)
            <x-filament::loading-indicator
                :attributes="
                    \Filament\Support\prepare_inherited_attributes(
                        new \Illuminate\View\ComponentAttributeBag([
                            'wire:loading.delay.' . config('filament.livewire_loading_delay', 'default') => '',
                            'wire:target' => $loadingIndicatorTarget,
                        ])
                    )->class([$iconClasses])
                "
            />
        @endif --}}
    @endif

    {{ $slot }}

    @if ($iconPosition === 'after')
        @if ($icon)
            {{-- <x-filament::icon
                :attributes="
                    \Filament\Support\prepare_inherited_attributes(
                        new \Illuminate\View\ComponentAttributeBag([
                            'alias' => $iconAlias,
                            'icon' => $icon,
                            'wire:loading.remove.delay.' . config('filament.livewire_loading_delay', 'default') => $hasLoadingIndicator,
                            'wire:target' => $hasLoadingIndicator ? $loadingIndicatorTarget : null,
                        ])
                    )->class([$iconClasses])
                "
            /> --}}
        @endif

        {{-- @if ($hasLoadingIndicator)
            <x-filament::loading-indicator
                :attributes="
                    \Filament\Support\prepare_inherited_attributes(
                        new \Illuminate\View\ComponentAttributeBag([
                            'wire:loading.delay.' . config('filament.livewire_loading_delay', 'default') => '',
                            'wire:target' => $loadingIndicatorTarget,
                        ])
                    )->class([$iconClasses])
                "
            />
        @endif --}}
    @endif
</{{ $tag }}>
