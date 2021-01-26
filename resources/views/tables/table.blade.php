<!-- table.blade.php -->
<div class="ls-table" x-data="{}">

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
    <div class="ls-table__main">
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
    <div class="ls-table__main --empty">
        {{ trans('ui::messages.no_results') }}
    </div>
    @show

    @endif
</div>
