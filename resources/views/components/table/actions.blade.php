@props([
    'actions',
    'alignment' => 'end',
    'entry' => null,
    'wrap' => false,
])

@php
    $actions = array_filter(
        $actions,
        function ($action) use ($entry): bool {
        // if (! $action instanceof \Filament\Tables\Actions\BulkAction) {
        $action->entry($entry);
        // }

            return $action->isVisible();
        },
    );

    // if (!$alignment instanceof Alignment) {
    // $alignment = Alignment::tryFrom($alignment) ?? $alignment;
    // }
    
@endphp

<div {{ $attributes->class([
        'flex shrink-0 items-center gap-3',
        'flex-wrap' => $wrap,
        'sm:flex-nowrap' => $wrap === '-sm',
        match ($alignment) {
            'start',
            'end',
            'right' => 'justify-end',
            'left' => 'justify-start',
            'center' => 'justify-center',
            'start md:end' => 'justify-start md:justify-end',
            default => $alignment,
        },
    ]) }}>
    @foreach ($actions as $action)
    {!! $action->toHtml() !!}
    @endforeach
</div>
