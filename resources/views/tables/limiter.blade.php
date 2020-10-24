<div class="table__limiter">

    <select onchange="window.location=this.value;">
        @foreach ([5, 10, 15, 25, 50, 75, 100, 150, 'all'] as $item)
        <option
            {{ $table->options->get('limit', $table->pagination->perPage()) == $item ? 'selected' : '' }}
            value="{{ url()->current() }}?{{ http_build_query([($table->prefix('limit')) => $item] + request()->query()) }}">
            @if ($item == 'all')
            {{ trans('ui::labels.show_all') }}</option>
        @else
        {{ $item }} {{ trans_choice('ui::labels.results', $item) }}</option>
        @endif
        @endforeach
    </select>
    
</div>
