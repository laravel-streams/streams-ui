@props([
    // 'alpineHidden' => null,
    // 'alpineSelected' => null,
    'entryAction' => null,
    'entryUrl' => null,
    'bulkActions' => [],
    'actions' => [],
    'columns' => [],
    'entry' => null,
    // 'striped' => false,
])

<tr @class([
    'relative h-full transition duration-75',
    'hover:bg-gray-50' => ($entryUrl || $entryAction),
    ...$this->table->getRowClasses($entry),
])>

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
    @php
        $color = $column->getColor();

        $columnClasses = [Arr::toCssClasses([
            ...[
                'whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6',
                'w-1' => $loop->last,
                match ($color) {
                    'gray' => '',
                    default => '',
                },
                is_string($color) ? "{$color}" : null,
            ],
        ])];

        $columnStyles = Arr::toCssStyles([
            \Streams\Ui\Support\Facades\Colors::colorVariables(
                $color,
                shades: [400, 500, 600],
            ),
        ]);

        $attributes = $column->getHtmlAttributeBag()
            ->merge([
                // 'href' => $href,
                // 'target' => $openInNewTab ? '_blank' : '_self',
                // 'disabled' => $disabled,
                // 'wire:loading.attr' => 'disabled',
                // 'type' => $tag == 'button' ? $type : false,
            ], escape: false)
            ->class([implode(' ', $columnClasses)])
            ->style([$columnStyles])

    @endphp
    <td {{ $attributes }}>
        @if ($entryUrl)
            <a href="{{ $entryUrl }}" class="hover:underline">{!! $column->entry($entry)->render() !!}</a>
        @else
        {!! $column->entry($entry)->render() !!}
        @endif
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
