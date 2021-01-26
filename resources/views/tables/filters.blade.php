<!-- filters.blade.php -->
@if ($table->filters->isNotEmpty())
<div class="ls-table__filters m-8">
    {!! Form::open([
        'method' => 'get',
        'class' => 'flex space-x-1 items-center',
    ]) !!}
    @foreach ($table->filters as $filter)
        @include('ui::tables.filter', ['filter' => $filter])
    @endforeach

    <button type="submit" class="py-2 px-4 text-sm font-bold text-black dark:text-white border-2 border-primary inline-block" value="Filter">Filter</button>

    <a href="{{ URL::current() }}{{ Request::has('view') ? '?view=' . Request::get('view') : '' }}" class="py-2 px-4 text-sm font-bold text-black dark:text-white border-2 border-primary inline-block">Clear</a>

    {!! Form::close() !!}
</div>
@endif
