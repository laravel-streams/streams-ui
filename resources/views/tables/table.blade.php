<div class="table__component" x-data="{}">

    @section('views')
    @include('ui::tables.views')
    @show

    @section('filters')
    @include('ui::tables.filters')
    @show

    @if ($table->rows->isNotEmpty())

    @section('form')
    {!! Form::open() !!}

    @section('table')
    <table {!! $table->htmlAttributes(['classes' => ['table']]) !!}>

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
    @show

    {!! Form::close() !!}
    @show

    @else

    @section('no_results')
    {{ trans('ui::messages.no_results') }}
    @show

    @endif
</div>