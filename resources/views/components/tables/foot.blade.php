<tfoot>
    @section('controls')
    {{-- Eventually loop through controls in table.data --}}
    {{-- if table.data.controls.isNotEmpty() --}}
    @if ($table->actions->isNotEmpty() || $table->pagination)
    <tr>
        <td colspan="100%">
            <div>

                <div class="c-table__actions">
                    {!! $table->actions->map->render()->implode('') !!}
                </div>


                @if ($table->pagination)
                <div class="c-table__limiter">

                    <label>{{ __('ui::labels.show') }}</label>

                    <select class="a-input" onchange="window.location=this.value;">
                        @foreach (['all', 5, 10, 15, 25, 50, 75, 100, 150] as $item)
                        <option
                            {{ $table->options->get('limit', $table->pagination->perPage()) == $item ? 'selected' : '' }}
                            value="{{ url()->current() }}?{{ http_build_query([($table->prefix('limit')) => $item] + request()->query()) }}">
                            @if ($item == 'all')
                            {{ trans('ui::labels.all') }}</option>
                        @else
                        {{ $item }}</option>
                        @endif
                        @endforeach
                    </select>
                    
                </div>

                <div class="c-table__pagination">
                    {{ $table->pagination->links('ui::support.pagination') }}
                </div>
                @endif
                
            </div>
        </td>
    </tr>
    @endif
    @show

    @if ($table->options->has('total_results'))
    <tr class="">
        <td colspan="100%">
            
            <small class="c-table__meta">
                {{ $table->options->get('total_results') }} {{ trans_choice('ui::labels.results', $table->options->get('total_results')) }}
            </small>

        </td>
    </tr>
    @endif
</tfoot>