<!-- filters.blade.php -->
@if ($table->filters->isNotEmpty())
<div class="c-table__filters">
    {!! Form::open([
        'method' => 'get',
    ]) !!}
    @foreach ($table->filters as $filter)
        @include('ui::tables.filter', ['filter' => $filter])
    @endforeach

    <div class="c-buttons">
        <button class="c-button" type="submit" value="Filter">Filter</button>

        <a class="c-button" href="{{ $table->clearUrl() }}">Clear</a>
    </div>

    {!! Form::close() !!}
</div>
@endif
