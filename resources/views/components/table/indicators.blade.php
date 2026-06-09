@props([
    'table',
])

@php
    $activeFilters = collect($table->getFilters())->filter(fn ($filter) => $filter->isActive());
    $tableName = $table->getName();
@endphp

@if ($activeFilters->isNotEmpty())
<div
    {{ $attributes->class(['fi-ta-filter-indicators flex items-start justify-between gap-x-3 bg-gray-50 px-3 py-1.5 sm:px-6']) }}
>
    <div class="flex flex-col gap-x-3 gap-y-1 sm:flex-row">
        <span
            class="whitespace-nowrap text-sm font-medium leading-6 text-gray-600"
        >Active filters:</span>

        <div class="flex flex-wrap gap-2">
            @foreach ($activeFilters as $filter)
                <span class="inline-flex items-center gap-1">
                    <x-ui::badge color="primary">
                        {{ $filter->getIndicatorLabel() }}: {{ $filter->getIndicatorValue() }}
                    </x-ui::badge>

                    <button
                        type="button"
                        class="text-gray-400 hover:text-gray-600"
                        wire:click="removeTableFilter('{{ $filter->getName() }}', null, true, '{{ $tableName }}')"
                        wire:loading.attr="disabled"
                        wire:target="removeTableFilter"
                        aria-label="Remove {{ $filter->getIndicatorLabel() }} filter"
                    >
                        <x-heroicon-m-x-mark class="h-4 w-4" />
                    </button>
                </span>
            @endforeach
        </div>
    </div>

    <div class="mt-0.5">
        <button
            type="button"
            class="text-sm font-medium text-gray-600 hover:text-gray-900"
            wire:click="resetTableFilters('{{ $tableName }}')"
            wire:loading.attr="disabled"
            wire:target="resetTableFilters,removeTableFilter"
        >
            Clear all
        </button>
    </div>
</div>
@endif
