@if ($table->filters->isNotEmpty())
<div>
    {!! Form::open([
        'method' => 'get'
    ]) !!}
    @foreach ($table->filters as $filter)
        {!! $filter->render() !!}
    @endforeach
    {!! Form::close() !!}
</div>
@endif
