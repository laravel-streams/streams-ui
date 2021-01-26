<!-- head.blade.php -->
<thead>
    <tr>

        <!-- ID Spacer -->
        <th class="hidden"></th>
        
        @if ($table->isSelectable())
        <th class="text-left">
        <input type="checkbox" x-on:click="alert('Select all');">
        </th>
        @endif

        @foreach ($table->columns as $column)
        <th {!! $column->htmlAttributes() !!}>

            @if ($column->sortable)
            <a href="{{ $column->href() }}">
                {!! $column->heading !!}
                @if ($column->direction == 'asc')
                @svg('heroicon-o-sort-ascending')
                @elseif ($column->direction == 'desc')
                @svg('heroicon-o-sort-descending')
                @endif
            </a>
            @else
            {!! $column->heading !!}
            @endif
        </th>
        @endforeach

        <!-- Buttons Spacer -->
        <th></th>

    </tr>
</thead>
