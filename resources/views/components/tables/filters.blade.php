<!-- filters.blade.php -->
@if ($table->filters->isNotEmpty())
<div class="c-table__filters">
    <div class="c-filters">
        
        {!! Form::open([
            'method' => 'get',
        ]) !!}
        
        <div class="c-filters__inputs">
        @foreach ($table->filters as $filter)
            <div class="c-input -{{ $filter->type }}-filter">
                {{ $filter->render() }}
            </div>
            @endforeach
        </div>
    
        <div class="c-buttons">
            <button class="a-button" type="submit" value="Filter">Filter</button>
    
            <a class="a-button -secondary" href="{{ $table->clearUrl() }}">Clear</a>
        </div>
    
        {!! Form::close() !!}

    </div>
</div>
@endif
