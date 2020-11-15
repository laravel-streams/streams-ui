<thead class="">
    <tr>

        @if ($table->isSortable())
        <th class="table__handle"></th>
        @endif

        @if ($table->isSelectable())
        <th class="">
        <input type="checkbox" x-on:click="alert('Select all');">
        </th>
        @endif

        @foreach ($table->columns as $column)
        <th {!! $column->htmlAttributes() !!}>

            @if ($column->sortable)
            <a href="{{ $column->href() }}">
                {!! $column->heading !!}
                @if ($column->direction == 'asc')
                {{-- {!! icon('sort-ascending') !!} --}}
                (ASC)
                @elseif ($column->direction == 'desc')
                {{-- {!! icon('sort-descending') !!} --}}
                (DESC)
                @else
                {{-- {!! icon('sortable') !!} --}}
                (--)
                @endif
            </a>
            @else
            {!! $column->heading !!}
            @endif
        </th>
        @endforeach

        <th></th>
    </tr>
</thead>
