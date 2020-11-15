<!-- body.blade.php -->
<tbody class="">
    @section('rows')
    @foreach ($table->rows as $row)
    <tr {!! $row->htmlAttributes() !!} ">

        @if ($table->isSortable()))
        <td class="">
            <input type="hidden" name="{{ $table->prefix('row[]') }}" value="{{ $row->key }}" />
        </td>
        @endif

        @if ($table->isSelectable())
        <td class=" pt-3">
            <input type="checkbox" name="{{ $table->prefix('selected[]') }}" value="{{ $row->key }}" />
        </td>
        @endif

        @foreach ($row->columns as $column)
        <td {!! $column->htmlAttributes() !!}>
            {!! $column->value !!}
        </td>
        @endforeach

        <td class="flex justify-end">
            {!! $row->buttons->render() !!}
        </td>

    </tr>
    @endforeach
    @show
</tbody>
