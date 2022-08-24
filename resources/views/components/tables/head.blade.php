<!-- head.blade.php -->
<thead>
    <tr>

        <!-- ID Spacer -->
        <th class="hidden"></th>
        
        @if ($table->actions->isNotEmpty())
        <th class="c-table__selector">
        <input type="checkbox" x-on:click="alert('Toggle all');">
        </th>
        @endif

        @foreach ($table->columns as $column)
        <th {!! $column->htmlAttributes() !!}>

            @if ($column->isSortable())
            <a href="{{ $column->href() }}">
                {!! __($column->heading()) !!}
                @if ($column->direction == 'asc')
                &#8595;
                @elseif ($column->direction == 'desc')
                &#8593;
                @else
                &#8597;
                @endif
            </a>
            @else
            {!! __($column->heading()) !!}
            @endif
        </th>
        @endforeach

        <!-- Buttons Spacer -->
        <th></th>

    </tr>
</thead>
