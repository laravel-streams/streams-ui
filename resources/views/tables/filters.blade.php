<!-- filters.blade.php -->
@if ($table->filters->isNotEmpty())
<div class="ls-table__filters">
    {!! Form::open([
        'method' => 'get',
    ]) !!}
    @foreach ($table->filters as $filter)
        @include('ui::tables.filter', ['filter' => $filter])
    @endforeach

    <button type="submit" value="Filter">Filter</button>

    <a href="{{ URL::current() }}{{ Request::has('view') ? '?view=' . Request::get('view') : '' }}">Clear</a>

    {!! Form::close() !!}
</div>
@endif
