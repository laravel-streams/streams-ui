<div>
    @if (Request::segment(4))
        @livewire('form', [
            'stream' => Request::segment(2),
            'entry' => Request::segment(4),
        ])
    @elseif (Request::segment(3))
        @livewire('form', [
            'stream' => Request::segment(2),
        ])
    @elseif (Request::segment(2))
        @livewire('table', [
            'stream' => Request::segment(2),
        ])
    @else
        Unknown
    @endif
</div>
