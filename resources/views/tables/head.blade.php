<!-- head.blade.php -->
<thead class="">
    <tr>

        @if ($table->isSortable())
        <th class="table__handle"></th>
        @endif

        @if ($table->isSelectable())
        <th class="text-left">
        <input type="checkbox" x-on:click="alert('Select all');">
        </th>
        @endif

        @foreach ($table->columns as $column)
        <th {!! $column->htmlAttributes([
            'class' => 'text-left',
        ]) !!}>

            @if ($column->sortable)
            <a href="{{ $column->href() }}">
                {!! $column->heading !!}
                @if ($column->direction == 'asc')
                @svg('heroicon-o-sort-ascending', [
                    'class' => 'inline h-5 w-5',
                ])
                @elseif ($column->direction == 'desc')
                @svg('heroicon-o-sort-descending', [
                    'class' => 'inline h-5 w-5',
                ])
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
