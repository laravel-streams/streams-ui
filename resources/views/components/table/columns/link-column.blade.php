@php
    $url = $column->getUrl();
@endphp

@if ($url)
    <a
        href="{{ $url }}"
        @if ($column->shouldOpenInNewTab()) target="_blank" rel="noopener noreferrer" @endif
        {{ $attributes->class(['font-semibold underline'])->merge($column->getHtmlAttributes()) }}
    >{!! $column->getValue() !!}</a>
@else
    <span {{ $attributes->class(['font-semibold'])->merge($column->getHtmlAttributes()) }}>{!! $column->getValue() !!}</span>
@endif
