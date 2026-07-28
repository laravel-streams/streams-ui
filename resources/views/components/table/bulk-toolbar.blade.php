@props([
    'bulkActions' => [],
])

@if ($bulkActions)
    <div
        x-show="selectedEntries.length > 0"
        x-cloak
        x-transition.opacity.duration.150ms
        class="pointer-events-none absolute inset-0 z-50 flex items-center justify-center px-4"
        role="toolbar"
        aria-label="{{ __('Bulk actions') }}"
    >
        <div
            class="pointer-events-auto flex min-w-[28rem] max-w-full items-center justify-between gap-6 rounded-2xl bg-gray-900 px-5 py-3 shadow-xl shadow-black/20 ring-1 ring-white/10"
        >
            <div class="flex shrink-0 items-center gap-2">
                <span
                    class="inline-flex min-h-7 min-w-7 items-center justify-center rounded-md bg-white px-2 text-sm font-semibold text-gray-900"
                    x-text="selectedEntries.length"
                ></span>
                <span class="text-sm font-medium text-white">
                    {{ __('Selected') }}
                </span>
            </div>

            <div class="flex items-center gap-2 overflow-x-auto">
                @foreach ($bulkActions as $action)
                    @if ($action->isVisible())
                        {!! $action->render() !!}
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif
