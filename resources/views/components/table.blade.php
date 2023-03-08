<div class="table__wrapper">

    @if (isset($slot))
    {!! $slot !!}
    @else

    <form {!! $component->htmlAttributes([
        //'action' => $component->action,
        //'method' => $component->method,
        //'enctype' => $component->enctype,
        'class' => 'form',
        'method' => 'POST',
        //'wire:submit.prevent' => 'save',
        'action' => '/streams/ui/' . $component->id . '/delete',
        ]) !!}>

        @ui('hidden', [
        'name' => '_id',
        'value' => $component->id,
        ])

        {{ csrf_field() }}

        <table {!! $component->htmlAttributes([
            'class' => [
            'table',
            ],
            ]) !!}>
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
                @if ($component->actions)
                <tr>
                    <td colspan="100%">
                        <div class="table__actions">
                            @foreach ($component->actions as $action)
                            @ui(Arr::pull($action, 'action', 'button'), Arr::parse($action, [
                            'entry' => $component->entry,
                            ]))
                            @endforeach
                        </div>
                    </td>
                </tr>
                @endif
                <tr>
                    <td colspan="100%">
                        <div>

                            @if (isset($component->pagination['links']))
                            <div class="table__pagination">
                                {!! $component->pagination['links']() !!}
                            </div>
                            @endif

                            @if (isset($component->pagination['total']))
                            <small class="table__meta">
                                {{ $component->pagination['total'] }}
                                {{ trans_choice('ui::labels.results', $component->pagination['total']) }}
                            </small>
                            @endif

                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
        
    </form>
    @endif
</div>
