@php
    $items = $breadcrumbs->getItems();
@endphp

<div {{ $attributes->class('-mx-4 mb-4 -mt-4 opacity-70') }}>
    @foreach ($items as $item)
        {!! $item->render() !!}
        {{-- @if (isset($item['href']))
            <a href="{{ $item['href'] }}" class="opacity-50 font-medium hover:opacity-75">{{ $item['title'] }}</a>
        @else
            <span class="opacity-50">{{ $item['title'] }}</span>
        @endif --}}
        {{-- @if (!$loop->last || count($breadcrumbsItems) == 1) --}}
        <span class="opacity-50 text-lg">&rsaquo;</span>
        {{-- @endif --}}
    @endforeach
</div>
