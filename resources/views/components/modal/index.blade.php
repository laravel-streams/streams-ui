@props([
    'alignment' => 'start',
    'ariaLabelledby' => null,
    'closeButton' => true,
    'closeByClickingAway' => true,
    'closeEventName' => 'close-modal',
    'description' => null,
    'displayClasses' => 'inline-block',
    'footer' => null,
    'footerActions' => [],
    'footerActionsAlignment' => 'start',
    'header' => null,
    'heading' => null,
    'icon' => null,
    'iconAlias' => null,
    'iconColor' => 'primary',
    'id' => null,
    'openEventName' => 'open-modal',
    'slideOver' => false,
    'stickyFooter' => false,
    'stickyHeader' => false,
    'trigger' => null,
    'visible' => true,
    'width' => 'sm',
])

<div
    @if ($ariaLabelledby)
        aria-labelledby="{{ $ariaLabelledby }}"
    @elseif ($heading)
        aria-labelledby="{{ "{$id}.heading" }}"
    @endif
    aria-modal="true"
    role="dialog"
    x-data="{
        isOpen: false,

        close: function () {
            
            this.isOpen = false;

            this.$refs.modalContainer.dispatchEvent(
                new CustomEvent('modal-closed', { id: '{{ $id }}' }),
            );
        },

        open: function () {

            this.isOpen = true;

            this.$refs.modalContainer.dispatchEvent(
                new CustomEvent('modal-opened', { id: '{{ $id }}' }),
            );
        },
    }"
    @if ($id)
        x-on:{{ $closeEventName }}.window="if ($event.detail.id === '{{ $id }}') close"
        x-on:{{ $openEventName }}.window="if ($event.detail.id === '{{ $id }}') open"
    @endif
    
    {{-- x-trap.noscroll="isOpen" --}}
    {{-- wire:ignore.self --}}
    @class([
        'ui-modal',
        'ui-width-screen' => $width === 'screen',
        $displayClasses,
    ])>

    @if ($trigger)
        <div
            x-on:click="open"
            {{ $trigger->attributes->class(['ui-modal-trigger flex cursor-pointer']) }}
        >
            {{ $trigger }}
        </div>
    @endif
    
    <div
        x-cloak
        x-show="isOpen"
        x-transition.duration.300ms.opacity
        @class([
            'fixed inset-0 z-40 min-h-full overflow-y-auto overflow-x-hidden transition',
            'flex items-center' => ! $slideOver,
        ])
    >
        <div
            aria-hidden="true"
            @if ($closeByClickingAway)
                @if (filled($id))
                    x-on:click="$dispatch('{{ $closeEventName }}', { id: '{{ $id }}' })"
                @else
                    x-on:click="close()"
                @endif
            @endif
            @class([
                'ui-modal-close-overlay fixed inset-0 bg-gray-950/50',
                'cursor-pointer' => $closeByClickingAway,
            ])
            style="will-change: transform"
        ></div>

        <div
            x-cloak
            x-ref="modalContainer"
            {{
                $attributes->class([
                    'pointer-events-none relative w-full transition',
                    'my-auto p-4' => ! ($slideOver || ($width === 'screen')),
                ])
            }}>
            
            <div
                x-cloak
                {{-- x-data="{ isShown: false }" --}}
                x-data="{ isShown: true }"
                x-init="
                    $nextTick(() => {
                        isShown = isOpen
                        $watch('isOpen', () => (isShown = isOpen))
                    })
                "
                @if (filled($id))
                    x-on:keydown.window.escape="$dispatch('{{ $closeEventName }}', { id: '{{ $id }}' })"
                @else
                    x-on:keydown.window.escape="close()"
                @endif
                x-show="isShown"
                x-transition:enter="duration-300"
                x-transition:leave="duration-300"
                @if ($width === 'screen')
                @elseif ($slideOver)
                    x-transition:enter-start="translate-x-full rtl:-translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="translate-x-full rtl:-translate-x-full"
                @else
                    x-transition:enter-start="scale-95"
                    x-transition:enter-end="scale-100"
                    x-transition:leave-start="scale-95"
                    x-transition:leave-end="scale-100"
                @endif
                @class([
                    'ui-modal-window pointer-events-auto relative flex w-full cursor-default flex-col bg-white shadow-xl ring-1 ring-gray-950/5',
                    'ui-modal-slide-over-window ms-auto overflow-y-auto' => $slideOver,
                    'h-screen' => $slideOver || ($width === 'screen'),
                    'mx-auto rounded-xl' => ! ($slideOver || ($width === 'screen')),
                    'hidden' => ! $visible,
                    match ($width) {
                        'xs' => 'max-w-xs',
                        'sm' => 'max-w-sm',
                        'md' => 'max-w-md',
                        'lg' => 'max-w-lg',
                        'xl' => 'max-w-xl',
                        '2xl' => 'max-w-2xl',
                        '3xl' => 'max-w-3xl',
                        '4xl' => 'max-w-4xl',
                        '5xl' => 'max-w-5xl',
                        '6xl' => 'max-w-6xl',
                        '7xl' => 'max-w-7xl',
                        'screen' => 'fixed inset-0',
                        default => $width,
                    },
                ])
            >
            
                @if ($heading || $header)
                    <div
                        @class([
                            'ui-modal-header flex px-6 pt-6',
                            'ui-sticky sticky top-0 z-10 border-b border-gray-200 bg-white pb-6' => $stickyHeader,
                            'rounded-t-xl' => $stickyHeader && ! ($slideOver || ($width === 'screen')),
                            match ($alignment) {
                                'start', 'left' => 'gap-x-5',
                                'center' => 'flex-col',
                                default => null,
                            },
                        ])
                    >
                        @if ($closeButton)
                            <div
                                @class([
                                    'absolute',
                                    'end-4 top-4' => ! $slideOver,
                                    'end-6 top-6' => $slideOver,
                                ])
                            >
                                <x-ui::action
                                    color="gray"
                                    icon="heroicon-o-x-mark"
                                    {{-- icon-alias="modal.close-action" --}}
                                    icon-size="lg"
                                    {{-- :label="__('ui::components/modal.actions.close.label')" --}}
                                    tabindex="-1"
                                    :x-on:click="filled($id) ? '$dispatch(' . \Illuminate\Support\Js::from($closeEventName) . ', { id: ' . \Illuminate\Support\Js::from($id) . ' })' : 'close()'"
                                    x-on:click="close()"
                                    class="ui-modal-close-btn"
                                >CLOSE</x-ui::action>
                            </div>
                        @endif

                        @if ($header)
                            {{ $header }}
                        @else
                            @if ($icon)
                                <div
                                    @class([
                                        'mb-5 flex items-center justify-center' => $alignment === 'center',
                                    ])
                                >
                                    <div
                                        @class([
                                            'rounded-full',
                                            match ($iconColor) {
                                                'gray' => 'ui-color-gray bg-gray-100',
                                                default => 'ui-color-custom bg-custom-100',
                                            },
                                            match ($alignment) {
                                                'start', 'left' => 'p-2',
                                                'center' => 'p-3',
                                                default => null,
                                            },
                                        ])
                                        {{-- @style([
                                            \Filament\Support\get_color_css_variables(
                                                $iconColor,
                                                shades: [100, 400, 500, 600],
                                            ) => $iconColor !== 'gray',
                                        ]) --}}
                                    >
                                        <x-ui::icon
                                            :alias="$iconAlias"
                                            :icon="$icon"
                                            @class([
                                                'ui-modal-icon h-6 w-6',
                                                match ($iconColor) {
                                                    'gray' => 'text-gray-500',
                                                    default => 'text-custom-600',
                                                },
                                            ])
                                        />
                                    </div>
                                </div>
                            @endif

                            <div
                                @class([
                                    'text-center' => $alignment === 'center',
                                ])
                            >
                                <x-ui::modal.heading>
                                    {{ $heading }}
                                </x-ui::modal.heading>

                                @if (filled($description))
                                    <x-ui::modal.description class="mt-2">
                                        {{ $description }}
                                    </x-ui::modal.description>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif

                {{-- @if (! \Filament\Support\is_slot_empty($slot)) --}}
                @if (!empty($slot))
                    <div
                        @class([
                            'ui-modal-content flex flex-col gap-y-4 py-6',
                            'flex-1' => ($width === 'screen') || $slideOver,
                            'pe-6 ps-[5.25rem]' => $icon && ($alignment === 'start'),
                            'px-6' => ! ($icon && ($alignment === 'start')),
                        ])
                    >
                        {{ $slot }}
                    </div>
                @endif

                @if ((!empty($footer)) || (is_array($footerActions) && count($footerActions)) || (! is_array($footerActions) && (!empty($footerActions))))
                    <div
                        @class([
                            'ui-modal-footer w-full',
                            'pe-6 ps-[5.25rem]' => $icon && ($alignment === 'start') && ($footerActionsAlignment !== 'center') && (! $stickyFooter),
                            'px-6' => ! ($icon && ($alignment === 'start') && ($footerActionsAlignment !== 'center') && (! $stickyFooter)),
                            'ui-sticky sticky bottom-0 border-t border-gray-200 bg-white py-5' => $stickyFooter,
                            'rounded-b-xl' => $stickyFooter && ! ($slideOver || ($width === 'screen')),
                            'pb-6' => ! $stickyFooter,
                            'mt-6' => (! $stickyFooter) && empty($slot),
                            'mt-auto' => $slideOver,
                        ])
                    >
                        @if (!empty($footer))
                            {{ $footer }}
                        @else
                            <div
                                @class([
                                    'ui-modal-footer-actions gap-3',
                                    match ($footerActionsAlignment) {
                                        'start', 'left' => 'flex flex-wrap items-center',
                                        'center' => 'flex flex-col-reverse sm:grid sm:grid-cols-[repeat(auto-fit,minmax(0,1fr))]',
                                        'end', 'right' => 'flex flex-row-reverse flex-wrap items-center',
                                        default => null,
                                    },
                                ])
                            >
                                @if (is_array($footerActions))
                                    @foreach ($footerActions as $action)
                                        {{ $action }}
                                    @endforeach
                                @else
                                    {{ $footerActions }}
                                @endif
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
