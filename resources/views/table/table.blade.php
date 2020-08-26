<section>

    @include('ui::table/partials/heading')
    
    @include('ui::table/partials/views')
    @include('ui::table/partials/filters')

    <div class="table__container">
        @if ($table->rows->isNotEmpty())
            {!! Form::open([
                'method' => 'post'
            ]) !!}
                <table {{-- {!! html_attributes($table->attr('attributes', [])) !!} --}}>
                    @include('ui::table/partials/head')
                    @include('ui::table/partials/body')
                    @include('ui::table/partials/foot')
                </table>
            {!! Form::close() !!}
        @else
         {{-- @todo view here. --}}
            {{ trans('ui::message.no_results') }}
        @endif
    </div>
    
</section>
