@if ($table->filters->isNotEmpty())
<div class="table__filters">
    {!! Form::open([
        'method' => 'get'
    ]) !!}
    @foreach ($table->filters as $filter)
        {!! $filter->render() !!}
    @endforeach
    {!! Form::close() !!}
</div>
@endif
