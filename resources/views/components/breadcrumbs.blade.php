<div>
    <div class="px-4 py-4 text-sm breadcrumbs">
        <ul class="flex space-x-2">
            @foreach ($component->items as $url => $item)
            @if (!$loop->last)
            <li><a class="underline" href="{{ URL::to($url) }}">{{ __($item) }}</a></li>
            <li class="opacity-25">/</li>
            @else
            <li class="active">{{ __($item) }}</li>
            @endif
            @endforeach
        </ul>
    </div>
</div>
