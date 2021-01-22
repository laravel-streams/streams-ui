<!-- table.blade.php -->
<div x-data="{}">

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
    <div class="m-8">
        <table {!! $table->htmlAttributes(['class' => ['table', 'min-w-full', 'dark:text-white']]) !!}>

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
    <div class="m-8">
        {{ trans('ui::messages.no_results') }}
    </div>
    @show

    @endif
</div>
