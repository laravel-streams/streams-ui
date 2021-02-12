<!-- table.blade.php -->
<div class="c-table" x-data="{}">

    @section('views')
    @include('ui::tables.views')
    @show

    @section('filters')
    @include('ui::tables.filters')
    @show

    @if ($table->rows->isNotEmpty())

    @section('form')
    {!! Form::open([
        'url' => $table->url(),
    ]) !!}

    @section('table')
    <div class="c-table__content">
        <table {!! $table->htmlAttributes() !!}>

            @section('head')
            @include('ui::tables.head')
            @show
    
            @section('body')
            @include('ui::tables.body')
            @show
    
            @section('foot')
            @include('ui::tables.foot')
            @show
    
        </table>
    </div>
    @show

    {!! Form::close() !!}
    @show

    @else

    @section('no_results')
    <div class="c-table__contents --empty">
        {{ trans('ui::messages.no_results') }}
    </div>
    @show

    @endif
</div>
