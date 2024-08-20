@props([
    'id' => null,
    'heading' => null,
    'description' => null,
    'alignment' => 'center',
    'closeEventName' => 'close-modal',
    'openEventName' => 'open-modal',
    'slideOver' => false,
    'visible' => false,
    'open' => false,
    'width' => 'sm',
])

<div
    aria-modal="true"
    role="dialog"
    x-data="{
        isOpen: {{ json_encode($open) }},

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
    x-on:{{ $closeEventName }}.window="close"
    x-on:{{ $openEventName }}.window="open"
    
    {{-- x-trap.noscroll="isOpen" --}}
    {{-- wire:ignore.self --}}
    >

    <div
        x-cloak
        x-show="isOpen"
        x-transition.duration.300ms.opacity
        @class([
            'fixed inset-0 z-50 min-h-full overflow-y-auto overflow-x-hidden transition',
            'flex items-center' => ! $slideOver,
        ])
    >
        <div
            aria-hidden="true"
            @if (filled($id))
                x-on:click="$dispatch('{{ $closeEventName }}', { id: '{{ $id }}' })"
            @else
                x-on:click="close()"
            @endif
            class="cursor-pointer fixed inset-0 bg-gray-950/50"
            style="will-change: transform"
        ></div>

        <div
            x-cloak
            x-ref="modalContainer"
            class="pointer-events-none relative w-full transition my-auto p-4"
            >
            
            <div
                x-cloak
                x-data="{ isShown: false }"
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
                @class([
                    'pointer-events-auto relative flex w-full cursor-default flex-col bg-white shadow-xl ring-1 ring-gray-950/5',
                    'h-screen' => $width === 'screen',
                    'mx-auto rounded-xl' => true,//$width !== 'screen',
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
            
                @if ($heading)
                    <div
                        @class([
                            'flex px-6 pt-6',
                        ])
                    >
                        <div class="absolute end-4 top-4">
                            <x-ui::action
                                color="black"
                                borderRadius="full"
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

                        <div>
                            <h2 class="text-base font-semibold leading-6 text-gray-950">
                                {{ $heading }}
                            </h2>

                            @if (filled($description))
                            <p class="mt-2 text-gray-500 dark:text-gray-400">
                                {{ $description }}
                            </p>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- @if (! \Filament\Support\is_slot_empty($slot)) --}}
                @if (!empty($slot))
                    <div
                        @class([
                            'ui-modal-content flex flex-col gap-y-4 py-6',
                            'flex-1' => ($width === 'screen') || $slideOver,
                        ])
                    >
                        {{ $slot }}
                    </div>
                @endif

                @if ((!empty($footer)) || (is_array($footerActions) && count($footerActions)) || (! is_array($footerActions) && (!empty($footerActions))))
                    <div
                        @class([
                            'ui-modal-footer w-full',
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
                                {{-- @if (is_array($footerActions))
                                    @foreach ($footerActions as $action)
                                        {{ $action }}
                                    @endforeach
                                @else
                                    {{ $footerActions }}
                                @endif --}}
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
