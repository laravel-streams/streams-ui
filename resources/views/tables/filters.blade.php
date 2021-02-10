<!-- filters.blade.php -->
@if ($table->filters->isNotEmpty())
<div class="ls-table__filters">
    {!! Form::open([
        'method' => 'get',
    ]) !!}
    @foreach ($table->filters as $filter)
        @include('ui::tables.filter', ['filter' => $filter])
    @endforeach

    <div class="ls-buttons">
        <button class="ls-button" type="submit" value="Filter">Filter</button>

        <a class="ls-button" href="{{ $table->clearUrl() }}">Clear</a>
    </div>

    {!! Form::close() !!}
</div>
@endif
