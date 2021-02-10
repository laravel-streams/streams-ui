<!-- body.blade.php -->
<tbody>
    @section('rows')
    @foreach ($table->rows as $row)
    <tr {!! $row->htmlAttributes() !!}>

        <td class="hidden">
            <input type="hidden" name="{{ $table->prefix('row[]') }}" value="{{ $row->key }}" />
        </td>

        @if ($table->isSelectable())
<<<<<<< HEAD
        <td>
=======
        <td class="ls-table__selector">
>>>>>>> b848fe7ab32993c597ee7a53757153012ea0da20
            <input type="checkbox" name="{{ $table->prefix('selected[]') }}" value="{{ $row->key }}" />
        </td>
        @endif

        @foreach ($row->columns as $column)
        <td {!! $column->htmlAttributes() !!}>{!! $column->value !!}</td>
        @endforeach

        <td class="ls-table__buttons">
            <nav class="ls-buttons">
            {!! $row->buttons->render() !!}
            </nav>
        </td>

    </tr>
    @endforeach
    @show
</tbody>
