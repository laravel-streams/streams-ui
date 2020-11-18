<!-- table.blade.php -->
<div class="" x-data="{}">

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
    <div class="px-8">
        <table {!! $table->htmlAttributes(['classes' => ['table', 'min-w-full']]) !!}>

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
    {{ trans('ui::messages.no_results') }}
    @show

    @endif
</div>
