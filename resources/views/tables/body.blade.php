<tbody class="table__body">
    @section('rows')
    @foreach ($table->rows as $row)
    <tr {!! $row->htmlAttributes() !!}>

        @section('handle')
        @if ($table->options->get('sortable'))
        <td class="table__column">
            {{-- {{ icon('fas fa-arrows') }} --}}
            <input type="hidden" name="{{ $table->prefix('order[]') }}" value="{{ $row->key }}" />
        </td>
        @endif
        @show

        @section('checkbox')
        @if ($table->actions->isNotEmpty())
        <td class="table__column">
            <input type="checkbox" name="{{ $table->prefix('id[]') }}" value="{{ $row->key }}" />
        </td>
        @endif
        @show

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
