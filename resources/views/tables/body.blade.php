<tbody class="table__body">
    @foreach ($table->rows as $row)
    <tr {!! $row->htmlAttributes() !!}>

        @if ($table->options->get('sortable'))
        <td class="table__column">
            {{-- {{ icon('fas fa-arrows') }} --}}
            <input type="hidden" name="{{ $table->prefix('order[]') }}" value="{{ $row->key }}" />
        </td>
        @endif

        @if ($table->actions->isNotEmpty())
        <td class="table__column">
            <input type="checkbox" name="{{ $table->prefix('id[]') }}" value="{{ $row->key }}" />
        </td>
        @endif

        @foreach ($row->columns as $column)
        <td {!! $column->htmlAttributes([
            'classes' => ['table__column']
        ]) !!}>
            {!! $column->value !!}
        </td>
        @endforeach

        <td class="table__column --buttons">
            {!! $row->buttons->render() !!}
        </td>

    </tr>
    @endforeach
</tbody>
