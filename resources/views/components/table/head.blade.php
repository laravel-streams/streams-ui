<thead class="bg-gray-50">
    <tr>

        @if ($bulkActions)
        <th scope="col" class="p-0 w-0" width="10px">
            <div class="px-3 py-4">
                <label class="flex">
                    <input type="checkbox"
                        class="rounded border-none bg-white shadow-sm ring-1 transition duration-75 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:pointer-events-none disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50"
                        value="all"
                        x-bind:checked="
                            
                            const records = getRecords()

                            if (records.length && areRecordsSelected(records)) {
                                
                                $el.checked = true

                                return 'checked'
                            }

                            $el.checked = false

                            return null
                        "
                        x-on:click="toggleSelectAllRecords">

                    <span class="sr-only">
                        Select/deselect all items for bulk actions.
                    </span>
                </label>
            </div>
        </th>
        @endif

        @foreach ($columns as $index => $column)

        @php
            $alignment = null;
        @endphp
        
        <th scope="col" class="py-3.5 pl-4 pr-3 text-left font-semibold text-gray-900 sm:pl-6">
            <{{ $column->isSortable() ? 'button' : 'span' }}
            @if ($column->isSortable())
            type="button"
            wire:click="sortTable('{{ $column->getName() }}')"
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

            <span
                class="font-semibold text-gray-950"
            >
                {{ $column->getLabel() }}
            </span>

            @if ($column->isSortable())
            <x-ui::icon
                :icon="$this->tableSortColumn == $column->getName() && $this->tableSortDirection === 'asc' ? 'heroicon-m-chevron-up' : 'heroicon-m-chevron-down'"
                @class([
                    'h-5 w-5 transition duration-75',
                    'text-gray-950' => $this->tableSortColumn == $column->getName(),
                    'text-gray-400 group-hover:text-gray-500 group-focus-visible:text-gray-500' => $this->tableSortColumn != $column->getName(),
                ])
            />

            <span class="sr-only">
                {{ $this->tableSortDirection === 'asc' ? __('Descending') : __('Ascending') }}
            </span>
            @endif
            </{{ $column->isSortable() ? 'button' : 'span' }}>
        </th>
        @endforeach

        @if ($actions)
        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
            <span class="sr-only">Row Actions</span>
        </th>
        @endif

    </tr>
</thead>
