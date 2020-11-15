<!-- filters.blade.php -->
@if ($table->filters->isNotEmpty())
<div class="">
    {!! Form::open([
        'method' => 'get'
    ]) !!}
    @foreach ($table->filters as $filter)
        {!! $filter->render() !!}
    @endforeach
    {!! Form::close() !!}
</div>
@endif
