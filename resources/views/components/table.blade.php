<div>
    <table {!! $component->htmlAttributes([
        'class' => 'm-4',
    ]) !!}>

        @if (isset($slot))
            {!! $slot !!}
        @else
            <thead>
                <tr style="text-align: left;">
                    <th></th>
                    @foreach ($component->columns as $column)
                    @livewire('table.header', array_merge($column, [
                        'text' => Arr::get($column, 'heading'),
                    ]))
                    @endforeach
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($component->entries as $entry)
                @livewire('table.row', [
                    'columns' => $component->columns,
                    'buttons' => $component->buttons,
                    'entry' => Arr::make($entry),
                ])
                @endforeach
            </thead>
        @endif
    </table>    
</div>
