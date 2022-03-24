<!-- table.blade.php -->
<div class="c-table" x-data="{}">

    @include('ui::tables.views')
    @include('ui::tables.filters')

    @if ($table->rows->isNotEmpty())

    {!! Form::open([
        'url' => $table->url(),
    ]) !!}

    <div class="c-table__content">
        <table {!! $table->htmlAttributes() !!}>

            @include('ui::tables.head')
            @include('ui::tables.body')
            @include('ui::tables.foot')
            
        </table>
    </div>

    {!! Form::close() !!}
    
    @else

    <div class="c-table__content --empty p-4">
        {{ trans('ui::messages.no_results') }}
    </div>

    @endif
</div>
