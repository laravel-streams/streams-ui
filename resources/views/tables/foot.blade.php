<!-- foot.blade.php -->
<tfoot>
    @section('controls')
    {{-- Eventually loop through controls in table.data --}}
    {{-- if table.data.controls.isNotEmpty() --}}
    @if ($table->actions->isNotEmpty() || $table->pagination)
    <tr>
        <td colspan="100%">
            <div>

                @include('ui::tables.actions')

                @if ($table->pagination)
                @include('ui::tables.limiter')
                @include('ui::tables.pagination')
                @endif
                
            </div>
        </td>
    </tr>
    @endif
    @show

    {{-- if table.data.information.isNotEmpty() --}}
    @if ($table->options->has('total_results'))
    <tr class="">
        <td colspan="100%">
            {{-- @todo loop through information in table.information --}}
            @include('ui::tables.meta')
        </td>
    </tr>
    @endif
</tfoot>
