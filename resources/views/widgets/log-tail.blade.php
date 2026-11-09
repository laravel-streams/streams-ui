@php
    $lines = $widget->getLines();
    $offset = $widget->getOffset();
@endphp
<div
    id="{{ $widget->getId() }}"
    data-lines="{{ json_encode($lines) }}"
    data-offset="{{ $offset }}"
    data-cap="{{ $widget->getCap() }}"
    x-data
    x-init="window.streamsLogTail && window.streamsLogTail.mount($el); {{ $widget->getRefreshOnAttributes()['x-init'] ?? '' }}"
    @if ($widget->getRefreshOn())
        data-refresh-on="{{ json_encode($widget->getRefreshOn()) }}"
    @endif
    {{ $attributes->merge($widget->getHtmlAttributes()) }}
>
    <div wire:ignore data-log-view class="overflow-y-auto font-mono text-xs whitespace-pre-wrap" style="height: {{ $widget->getHeight() }}px">
        @foreach ($lines as $line)
            <div>{{ $line }}</div>
        @endforeach
    </div>
</div>
