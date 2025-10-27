<x-ui::grid.column {{ $attributes->class([
        'flex',
        'rounded-2xl',
        'bg-gray-200',
        'p-4',
    ]) }}>
    {!! $slot !!}
</x-ui::grid.column>
