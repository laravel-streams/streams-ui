<!-- limiter.blade.php -->
<div class="ls-table__limiter">

    <label>{{ __('ui::labels.show') }}</label>

    <select onchange="window.location=this.value;">
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
