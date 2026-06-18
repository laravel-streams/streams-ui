@props([
    'table' => null,
    'columns' => [],
    'actions' => [],
    'bulkActions' => [],
    'tableName' => 'default',
])

<thead {{
    $attributes->except(['table', 'columns', 'actions', 'bulkActions'])->merge([
        'class' => $attributes->get('class', 'bg-gray-50'),
    ])
}}>
    <tr>

        @if ($bulkActions)
        <th scope="col" class="p-0 w-0" width="10px">
            <div class="px-3 flex items-center" data-select-all-trigger>
                <label class="flex cursor-pointer">
                    <input type="checkbox"
                        wire:ignore.self
                        data-select-all-checkbox
                        class="rounded border-none bg-white shadow-sm ring-1 transition duration-75 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:pointer-events-none disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50"
                        value="all">

                    <span class="sr-only">
                        Select/deselect all items for bulk actions.
                    </span>
                </label>
                <div class="ml-2 relative" data-bulk-menu>
                    <button type="button" data-bulk-menu-trigger class="p-1 text-gray-700 rounded-md disabled:border-transparent disabled:bg-none disabled:opacity-50" :class="selectedEntries.length > 0 ? 'bg-gray-200 hover:bg-gray-300 text-black' : null" aria-haspopup="true" :aria-expanded="bulkMenuOpen.toString()" x-bind:disabled="selectedEntries.length == 0">
                        <x-ui::icon icon="heroicon-o-ellipsis-vertical" class="h-5 w-5 text-gray-400 hover:text-gray-500"/>
                    </button>
                    <div x-show="bulkMenuOpen" x-cloak class="absolute bg-white border rounded-lg shadow-lg overflow-hidden left-0 w-48 z-10">
                        {{-- Bulk Actions --}}
                        @foreach ($bulkActions as $action)
                            {!! $action
                                ->mergeHtmlAttributes([
                                    'class' => 'w-full',
                                ])
                                ->borderRadius('none')
                                ->render() !!}
                        @endforeach

                    </div>
                </div>
            </div>
        </th>
        @endif

        @foreach ($columns as $index => $column)

        @php
            $alignment = null;

            if ($column->isHidden()) {
                continue;
            }
        @endphp
        
        <th scope="col" class="py-2.5 {{ ($bulkActions && $loop->first) ? 'pl-0' : 'pr-4 sm:pl-6' }} text-left font-semibold text-gray-900">
            <{{ $column->isSortable() ? 'button' : 'span' }}
            @if ($column->isSortable())
            type="button"
            wire:click="sortTable('{{ $column->getName() }}', null, '{{ $tableName }}')"
            @endif
            @class([
                'group flex w-full items-center gap-x-1',
                // 'whitespace-nowrap' => ! $wrap,
                // 'whitespace-normal' => $wrap,
                match ($alignment) {
                    'start' => 'justify-start',
                    'center' => 'justify-center',
                    'end' => 'justify-end',
                    'left' => 'justify-start rtl:flex-row-reverse',
                    'right' => 'justify-end rtl:flex-row-reverse',
                    default => $alignment,
                },
            ])
            >
            @if ($column->isSortable())
                <span class="sr-only">
                    Sort by
                </span>
            @endif

            @if ($tooltip = $column->getTooltip())
            <span x-data="{tooltip: '{{ addslashes($tooltip) }}'}">
                <x-ui::icon icon="heroicon-m-question-mark-circle" class="h-5 w-5 opacity-40 mr-1" x-tooltip.interactive.html="tooltip"/>
            </span>
            @endif

            <span
                class="font-semibold text-gray-950 whitespace-nowrap"
            >
                {{ $column->getLabel() }}
            </span>

            @if ($column->isSortable())
            <x-ui::icon
                :icon="$this->getTableSortColumn($tableName) == $column->getName() && $this->getTableSortDirection($tableName) === 'asc' ? 'heroicon-m-chevron-up' : 'heroicon-m-chevron-down'"
                @class([
                    'h-5 w-5 transition duration-75',
                    'text-gray-950' => $this->getTableSortColumn($tableName) == $column->getName(),
                    'text-gray-400 group-hover:text-gray-500 group-focus-visible:text-gray-500' => $this->getTableSortColumn($tableName) != $column->getName(),
                ])
            />

            <span class="sr-only">
                {{ $this->getTableSortDirection($tableName) === 'asc' ? __('Descending') : __('Ascending') }}
            </span>
            @endif
            </{{ $column->isSortable() ? 'button' : 'span' }}>
        </th>
        @endforeach

        @if ($actions)
        <th scope="col" class="relative w-full py-2.5 pl-3 pr-4 sm:pr-6">
            <span class="sr-only">Row Actions</span>
        </th>
        @endif

    </tr>
</thead>
