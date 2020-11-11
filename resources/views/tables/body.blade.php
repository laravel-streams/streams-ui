<tbody class="table__body">
    @section('rows')
    @foreach ($table->rows as $row)
    <tr {!! $row->htmlAttributes() !!}>

        @if ($table->isSortable()))
        <td class="table__handle">
            <input type="hidden" name="{{ $table->prefix('row[]') }}" value="{{ $row->key }}" />
        </td>
        @endif

        @if ($table->isSelectable())
        <td class="table__column">
            <input type="checkbox" name="{{ $table->prefix('selected[]') }}" value="{{ $row->key }}" />
        </td>
        @endif

        @foreach ($row->columns as $column)
        <td {!! $column->htmlAttributes() !!}>
            {!! $column->value !!}
        </td>
        @endforeach

        <td class="table__column --buttons">
            {!! $row->buttons->render() !!}
        </td>

    </tr>
    @endforeach
    @show
</tbody>
