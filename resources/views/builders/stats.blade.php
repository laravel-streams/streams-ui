@php
    $columns = 3;//$this->getColumns();
@endphp

<x-ui::widget>
    <div
        @if ($pollingInterval = $this->getPollingInterval())
            wire:poll.{{ $pollingInterval }}
        @endif
        @class([
            'grid gap-6 mb-6',
            'md:grid-cols-1' => $columns === 1,
            'md:grid-cols-2' => $columns === 2,
            'md:grid-cols-3' => $columns === 3,
            'md:grid-cols-2 xl:grid-cols-4' => $columns === 4,
        ])>
        @foreach ($this->getStats() as $stat)
            {{ $stat->render() }}
        @endforeach
    </div>
</x-filament-widgets::widget>
