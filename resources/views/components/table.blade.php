<div class="table__wrapper">
    <table {!! $component->htmlAttributes([
        'class' => [
            'table',
        ],
    ]) !!}>

        @if (isset($slot))
            {!! $slot !!}
        @else

            @if ($component->caption)
            <caption>{{ $component->caption }}</caption>
            @endif

            <thead>
                <tr>
                    @if ($component->selectable)
                    <th><span class="sr-only">Select Rows</span></th>
                    @endif
                    @foreach ($component->columns as $column)
                    @if (isset($column['header']))
                        @ui('table.header', $column['header'])
                    @endif
                    @endforeach
                    @if ($component->buttons)
                    <th><span class="sr-only">Actions</span></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($component->entries as $entry)
                @ui('table.row', [
                    'selectable' => $component->selectable,
                    'columns' => $component->columns,
                    'buttons' => $component->buttons,
                    'entry' => Arr::make($entry),
                ])
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="100%">
                        <div>

                            <div class="table__pagination">
                                {!! $component->pagination['links']() !!}
                            </div>
                            
                            <small class="table__meta">
                                {{ $component->pagination['total'] }}
                                {{ trans_choice('ui::labels.results', $component->pagination['total']) }}
                            </small>

                        </div>
                    </td>
                </tr>
            </tfoot>
        @endif
    </table>    
</div>
