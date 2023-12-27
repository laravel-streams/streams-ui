<thead class="bg-gray-50">
    <tr>

        @if ($bulkActions)
        <th scope="col" class="p-0 w-0" width="10px">
            <div class="px-3 py-4">
                <label class="flex">
                    <input type="checkbox"
                        class="rounded border-none bg-white shadow-sm ring-1 transition duration-75 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:pointer-events-none disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50"
                        value="all" x-model="selectedRecords">

                    <span class="sr-only">
                        Select/deselect all items for bulk actions.
                    </span>
                </label>
            </div>
        </th>
        @endif

        @foreach ($columns as $index => $column)
        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold uppercase text-gray-900 sm:pl-6">
            @if ($column->isSortable())
            <a href="#todo-sort[{{ $column->getName() }}]">
                {{ __($column->getLabel()) }}

                @svg('heroicon-o-chevron-down', 'inline-block w-4 h-4 ml-1 text-gray-400')
            </a>
            @else
            {{ __($column->getLabel()) }}
            @endif
        </th>
        @endforeach

        @if ($actions)
        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
            <span class="sr-only">Row Actions</span>
        </th>
        @endif

    </tr>
</thead>
