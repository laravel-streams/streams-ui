<tfoot>
    @section('controls')
    {{-- Eventually loop through controls in table.data --}}
    {{-- if table.data.controls.isNotEmpty() --}}
    @if ($table->actions->isNotEmpty() || $table->pagination)
    <tr>
        <th colspan="100%">
            <div class="table__footer">

                @include('ui::tables.actions')

                @if ($table->pagination)
                @include('ui::tables.limiter')
                @include('ui::tables.pagination')
                @endif
                
            </div>
        </th>
    </tr>
    @endif
    @show

    {{-- if table.data.information.isNotEmpty() --}}
    @if ($table->options->has('total_results'))
    <tr>
        <td colspan="100%">
            {{-- Eventually loop through information in table.information --}}
            @include('ui::tables.total')
        </td>
    </tr>
    @endif
</tfoot>
