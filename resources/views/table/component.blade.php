<section>

    {{ $filters }}
    {{ $heading }}

    <div class="table__container">
        @if ($table->rows->isNotEmpty())
            <form>
                {{-- <table {!! html_attributes($table->attr('attributes', [])) !!}> --}}
                <table>
                    {{-- @include('ui::table/partials/header')
                    @include('ui::table/partials/body')
                    @include('ui::table/partials/footer') --}}
                </table>
            </form>
        @else
            {{ trans('ui::message.no_results') }}
        @endif
    </div>
    
</section>
