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
    'closeButton' => true,
    'closeAction' => null,
])

<div
    aria-modal="true"
    role="dialog"
    x-data="{
        isOpen: {{ json_encode($open) }},
        showDirtyGuard: false,
        formSnapshot: null,
        openedWithHistory: false,
        closingProgrammatically: false,
        modalHistoryKey: 'ui-modal-{{ filled($id) ? $id : 'default' }}',

        init: function () {
            window.addEventListener('popstate', () => this.handlePopstate())

            if (this.isOpen) {
                this.$nextTick(() => this.afterOpen())
            }
        },

        captureFormSnapshot: function () {
            const root = this.$refs.modalPanel

            if (! root) {
                return ''
            }

            const fields = root.querySelectorAll('input, textarea, select')

            return Array.from(fields)
                .filter((field) => ! ['hidden', 'submit', 'button', 'reset'].includes(field.type))
                .map((field) => {
                    if (field.type === 'checkbox' || field.type === 'radio') {
                        return field.name + ':' + field.type + ':' + (field.checked ? '1' : '0')
                    }

                    return field.name + ':' + field.type + ':' + field.value
                })
                .join('|')
        },

        isDirty: function () {
            if (this.formSnapshot === null) {
                return false
            }

            return this.captureFormSnapshot() !== this.formSnapshot
        },

        pushHistoryEntry: function () {
            const state = { ...(history.state ?? {}), [this.modalHistoryKey]: true }

            history.pushState(state, document.title, window.location.href)
            this.openedWithHistory = true
        },

        afterOpen: function () {
            this.formSnapshot = this.captureFormSnapshot()

            if (! this.openedWithHistory) {
                this.pushHistoryEntry()
            }
        },

        requestClose: function () {
            if (this.isDirty()) {
                this.showDirtyGuard = true

                return
            }

            this.close()
        },

        keepEditing: function () {
            this.showDirtyGuard = false
        },

        discardChanges: function () {
            this.showDirtyGuard = false
            this.close()
        },

        handlePopstate: function () {
            if (this.closingProgrammatically) {
                this.closingProgrammatically = false

                return
            }

            if (! this.isOpen) {
                return
            }

            if (this.isDirty()) {
                this.pushHistoryEntry()
                this.showDirtyGuard = true

                return
            }

            this.openedWithHistory = false
            this.doClose()
        },

        doClose: function () {
            this.isOpen = false
            this.showDirtyGuard = false
            this.formSnapshot = null
            this.$wire?.unmountAction?.()
            this.$refs.modalContainer?.dispatchEvent(
                new CustomEvent('modal-closed', { detail: { id: '{{ $id }}' } }),
            )
        },

        close: function () {
            if (this.isOpen && this.openedWithHistory) {
                this.openedWithHistory = false
                this.closingProgrammatically = true
                history.back()
            }

            this.doClose()
        },

        open: function () {
            this.isOpen = true
            this.$refs.modalContainer?.dispatchEvent(
                new CustomEvent('modal-opened', { detail: { id: '{{ $id }}' } }),
            )

            this.$nextTick(() => this.afterOpen())
        },
    }"
    x-on:{{ $closeEventName }}.window="if ($event.detail?.id === undefined || $event.detail?.id === '{{ $id }}') requestClose()"
    x-on:{{ $openEventName }}.window="if ($event.detail?.id === undefined || $event.detail?.id === '{{ $id }}') open()"
    
    {{-- x-trap.noscroll="isOpen" --}}
    wire:ignore.self
    >

    {{-- Teleport out of page stacking contexts (e.g. main.z-10) so backdrop covers topbar. --}}
    <template x-teleport="body">
        <div
            data-ui-modal-root
            x-cloak
            x-show="isOpen"
            x-transition.duration.300ms.opacity
            @class([
                'fixed inset-0 z-50 min-h-full overflow-y-auto overflow-x-hidden transition',
                'flex items-center' => ! $slideOver,
            ])
        >
            <div
                data-ui-modal-backdrop
                aria-hidden="true"
                @if (filled($id))
                    x-on:click="$dispatch('{{ $closeEventName }}', { id: '{{ $id }}' })"
                @else
                    x-on:click="requestClose()"
                @endif
                class="cursor-pointer fixed inset-0 backdrop-blur-sm"
                style="background-color: rgba(var(--primary-500), 0.5); will-change: transform"
            ></div>

            <div
                x-show="showDirtyGuard"
                x-cloak
                data-ui-modal-dirty-guard
                class="pointer-events-auto absolute inset-0 z-10 flex items-center justify-center p-4"
                style="background-color: rgba(0, 0, 0, 0.45)"
            >
                <div
                    class="w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl shadow-black/10 ring-1 ring-gray-950/5"
                    role="alertdialog"
                    aria-labelledby="ui-modal-dirty-guard-heading"
                >
                    <p id="ui-modal-dirty-guard-heading" class="text-base font-medium text-gray-950">
                        Discard unsaved changes?
                    </p>
                    <div class="mt-6 flex flex-row-reverse flex-wrap gap-3">
                        <button
                            type="button"
                            data-ui-modal-dirty-discard
                            x-on:click="discardChanges()"
                            class="rounded-lg bg-gray-950 px-4 py-2 text-sm font-semibold text-white"
                        >
                            Discard
                        </button>
                        <button
                            type="button"
                            data-ui-modal-dirty-keep-editing
                            x-on:click="keepEditing()"
                            class="rounded-lg px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-gray-300"
                        >
                            Keep editing
                        </button>
                    </div>
                </div>
            </div>

            <div
                x-cloak
                x-ref="modalContainer"
                class="pointer-events-none relative w-full transition my-auto p-4"
                >
                
                <div
                    x-cloak
                    x-ref="modalPanel"
                    @if (filled($id))
                        x-on:keydown.window.escape="$dispatch('{{ $closeEventName }}', { id: '{{ $id }}' })"
                    @else
                        x-on:keydown.window.escape="requestClose()"
                    @endif
                    x-show="isOpen"
                    x-transition:enter="duration-300"
                    x-transition:leave="duration-300"
                    @class([
                        'pointer-events-auto relative flex w-full cursor-default flex-col bg-white shadow-xl shadow-black/10 ring-1 ring-gray-950/5',
                        'h-screen' => $width === 'screen',
                        'mx-auto rounded-2xl' => true,//$width !== 'screen',
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
                    @if ($closeButton && $closeAction)
                        <div class="absolute end-4 top-4 z-10">
                            {!! $closeAction->render() !!}
                        </div>
                    @endif

                    @if ($heading)
                        <div
                            @class([
                                'flex px-6 pt-6 mb-6',
                            ])
                        >
                            <div>
                                <h2 class="text-2xl font-semibold leading-6 text-gray-950">
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
                                'ui-modal-content flex flex-col gap-y-4 px-6',
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
    </template>
</div>
