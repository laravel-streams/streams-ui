<tr class="hover:bg-gray-50">

    @if ($bulkActions)
    <td class="p-0 w-0">
        <div class="px-3 py-4">
            <label class="flex">
                <input type="checkbox"
                    x-model="selectedEntries"
                    wire:model="selectedTableEntries"
                    class="ui-table-entry-checkbox rounded border-none bg-white shadow-sm ring-1 transition duration-75 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:pointer-events-none disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50"
                    value="{{ $entry->id }}">

                <span class="sr-only">
                    Select/deselect item {{ $entry->id }} for bulk actions.
                </span>
            </label>
        </div>
    </td>
    @endif

    @foreach ($columns as $index => $column)
    <td
        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 {{ $loop->first ? 'w-1' : '' }}">
        {!! $column->entry($entry)->render() !!}
    </td>
    @endforeach
    @if ($actions)
    <td class="whitespace-nowrap py-4 pr-4 pl-3 text-sm font-medium text-gray-900 sm:pl-6">
        <x-ui::table.actions
            :actions="$actions"
            {{-- :alignment="(!$contentGrid) ? 'start md:end' : 'start'" --}}
            :alignment="'right'"
            :entry="$entry"
            {{-- wrap="-sm" --}}
            {{-- :class="$entryActionsClasses" --}}
        />
    </td>
    @endif
</tr>
