<div>
    <table {!! $component->htmlAttributes([
        //'action' => $component->action,
        //'method' => $component->method,
        //'enctype' => $component->enctype,
    ]) !!}>

        @if (isset($slot))
            {!! $slot !!}
        @else
            <thead>
                <tr>
                    @foreach ($component->columns as $column)
                    @livewire('table.header', array_merge($column, [
                        'text' => Arr::get($column, 'heading'),
                    ]))
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($component->entries as $entry)
                @livewire('table.row', [
                    'columns' => $component->columns,
                    'entry' => Arr::make($entry),
                ])
                @endforeach
            </thead>
        @endif
    </table>    
</div>
