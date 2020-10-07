<tfoot>
    @if ($table->actions->isNotEmpty() || $table->pagination)
    <tr>
        <th colspan="100%">
            <div class="table__footer">
                <div class="table__actions">
                    {!! $table->actions->render() !!}
                </div>

                @if ($table->pagination)
                <div class="table__limit">

                    <select onchange="window.location=this.value;">
                        @foreach ([5, 10, 15, 25, 50, 75, 100, 150, 'all'] as $item)
                        <option
                            {{ $table->options->get('limit', $table->pagination->perPage()) == $item ? 'selected' : '' }}
                            value="{{ url()->current() }}?{{ http_build_query([($table->prefix('limit')) => $item] + request()->query()) }}">
                            @if ($item == 'all')
                            {{ trans('ui::message.show_all') }}</option>
                        @else
                        {{ $item }} {{ trans('ui::message.results') }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="table__pagination">
                    {{ $table->pagination->links() }}
                </div>
                @endif
            </div>
        </th>
    </tr>
    @endif

    @if ($table->options->has('total_results'))
    <tr>
        <td colspan="100%">
            <small class="table__total">
                {{ $table->options->get('total_results') }} {{ trans_choice('ui::labels.results', $table->options->get('total_results')) }}
            </small>
        </td>
    </tr>
    @endif
</tfoot>
