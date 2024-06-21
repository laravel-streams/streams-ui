@props([
    'color' => 'primary',
    'deleteButton' => null,
    'disabled' => false,
    'form' => null,
    'href' => null,
    'icon' => null,
    'iconAlias' => null,
    'iconPosition' => 'before',
    'iconSize' => 'sm',
    'keyBindings' => null,
    'loadingIndicator' => true,
    'size' => 'md',
    'tag' => 'div',
    'target' => null,
    'tooltip' => null,
    'type' => 'button',
])

@php
    $isDeletable = count($deleteButton?->attributes->getAttributes() ?? []) > 0;

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

    $wireTarget = $loadingIndicator ? $attributes->whereStartsWith(['wire:target', 'wire:click'])->filter(fn ($value): bool => filled($value))->first() : null;

    $hasLoadingIndicator = filled($wireTarget) || ($type === 'submit' && filled($form));

    if ($hasLoadingIndicator) {
        $loadingIndicatorTarget = html_entity_decode($wireTarget ?: $form, ENT_QUOTES);
    }

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
                'wire:target' => ($hasLoadingIndicator && $loadingIndicatorTarget) ? $loadingIndicatorTarget : null,
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
                    'gray' => 'bg-gray-50 text-gray-600',
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
                            'wire:loading.remove.delay.' . config('filament.livewire_loading_delay', 'default') => $hasLoadingIndicator,
                            'wire:target' => $hasLoadingIndicator ? $loadingIndicatorTarget : null,
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

    <span class="grid">
        {{ $slot }}
    </span>

    @if ($isDeletable)
        <button
            type="button"
            {{
                $deleteButton
                    ->attributes
                    ->except(['label'])
                    ->class([
                        '-my-1 -me-2 -ms-1 flex items-center justify-center p-1 outline-none transition duration-75',
                        match ($color) {
                            'gray' => 'text-gray-700/50 hover:text-gray-700/75 focus-visible:text-gray-700/75',
                            default => 'text-custom-700/50 hover:text-custom-700/75 focus-visible:text-custom-700/75',
                        },
                    ])
            }}
        >
            {{-- <x-filament::icon
                alias="badge.delete-button"
                icon="heroicon-m-x-mark"
                class="h-3.5 w-3.5"
            /> --}}

            @if (filled($label = $deleteButton->attributes->get('label')))
                <span class="sr-only">
                    {{ $label }}
                </span>
            @endif
        </button>
    @elseif ($iconPosition === 'after')
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
