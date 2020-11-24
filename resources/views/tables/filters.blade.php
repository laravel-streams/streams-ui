<!-- filters.blade.php -->
@if ($table->filters->isNotEmpty())
<div class="px-8">
    {!! Form::open([
        'method' => 'get'
    ]) !!}
    @foreach ($table->filters as $filter)
        @include('ui::tables.filter', ['filter' => $filter])
    @endforeach
    {!! Form::close() !!}
</div>
@endif
