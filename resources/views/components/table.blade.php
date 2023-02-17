<div>
    <table {!! $component->htmlAttributes([
        'class' => 'm-4',
    ]) !!}>

        @if (isset($slot))
            {!! $slot !!}
        @else

            @if ($component->caption)
            <caption>{{ $component->caption }}</caption>
            @endif

            <thead>
                <tr style="text-align: left;">
                    @if ($component->selectable)
                    <th></th>
                    @endif
                    @foreach ($component->columns as $column)
                    @if (isset($column['header']))
                        @livewire('table.header', $column['header'])
                    @endif
                    @endforeach
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($component->entries as $entry)
                @livewire('table.row', [
                    'selectable' => $component->selectable,
                    'columns' => $component->columns,
                    'buttons' => $component->buttons,
                    'entry' => Arr::make($entry),
                ])
                @endforeach
            </thead>
        @endif
    </table>    
</div>
