<tbody class="table__body">
    @foreach ($table->rows as $row)
    {{-- <tr {!! html_attributes($row->attr('attributes', [])) !!}> --}}
    <tr>

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
        {{-- <td {{ html_attributes($column->attr('attributes', [])) }}> --}}
        <td>
            {!! $column->value !!}
        </td>
        @endforeach

        <td class="table__column -actions">
            {!! $row->buttons->render() !!}
        </td>

    </tr>
    @endforeach
</tbody>
