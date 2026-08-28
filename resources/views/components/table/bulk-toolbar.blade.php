@props([
    'bulkActions' => [],
])

@if ($bulkActions)
    <div
        x-show="selectedEntries.length > 0 || selectAllMatching"
        x-cloak
        x-transition.opacity.duration.150ms
        class="pointer-events-none absolute inset-0 z-50 flex items-center justify-center px-4"
        role="toolbar"
        aria-label="{{ __('Bulk actions') }}"
    >
        <div
            class="pointer-events-auto flex min-w-[28rem] max-w-full items-center justify-between gap-6 rounded-2xl bg-gray-900 px-5 py-3 shadow-xl shadow-black/20 ring-1 ring-white/10"
        >
            <div class="flex min-w-0 flex-col gap-3">
                <div class="flex shrink-0 items-center gap-2">
                    <span
                        class="inline-flex min-h-7 min-w-7 items-center justify-center rounded-md bg-white px-2 text-sm font-semibold text-gray-900"
                        x-text="selectedCount()"
                    ></span>
                    <span class="text-sm font-medium text-white">
                        {{ __('Selected') }}
                    </span>
                </div>

                <button
                    type="button"
                    x-show="!selectAllMatching && allEntriesSelected && matchingTotalCount > selectedEntries.length"
                    x-cloak
                    class="pointer-events-auto mt-1 w-fit text-left text-xs font-medium text-white/80 hover:text-white underline underline-offset-2"
                    x-on:click.stop="enableSelectAllMatching()"
                >
                    {{ __('Select all') }}
                    <span x-text="matchingTotalCount"></span>
                    {{ __('matching') }}
                </button>

                <span
                    x-show="selectAllMatching"
                    x-cloak
                    class="mt-1 text-xs font-medium text-white/70"
                >
                    {{ __('All matching results') }}
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
