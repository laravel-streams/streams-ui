<div>
    @if ($items)    
    <div class="breadcrumbs">
        <ul class="flex space-x-2">
            @foreach ($items as $url => $item)
            @if (!$loop->last)
            <li><a href="{{ URL::to($url) }}">{{ __($item) }}</a></li>
            <li>/</li>
            @else
            <li class="active">{{ __($item) }}</li>
            @endif
            @endforeach
        </ul>
    </div>
    @endif
</div>
