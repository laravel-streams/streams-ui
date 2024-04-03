@props([
    'footer' => null,
    'header' => null,
    'reorderable' => false,
])

<table
    {{ $attributes->class(['w-full table-auto divide-y divide-gray-200 text-start']) }}
>
    {{-- @if ($header) --}}
        <thead class="bg-gray-50">
            <tr>
                {{-- {{ $header }} --}}
                <x-ui::tables.components.head>
            </tr>
        </thead>
    {{-- @endif --}}

    <tbody
        {{-- @if ($reorderable)
            x-on:end.stop="$wire.reorderTable($event.target.sortable.toArray())"
            x-sortable
        @endif --}}
        class="divide-y divide-gray-200 whitespace-nowrap"
    >
        {{ $slot }}
    </tbody>

    {{-- @if ($footer)
        <tfoot class="bg-gray-50 dark:bg-white/5">
            <tr>
                {{ $footer }}
            </tr>
        </tfoot>
    @endif --}}
</table>
