<div
    @if($getId()) id="{{ $getId() }}" @endif
    {!! $getHtmlAttributeBag() !!}
    {{ $attributes->class('flex items-center gap-4 py-3 px-4') }}
>
    @if($icon = $getIcon())
        <div class="flex-shrink-0 text-gray-500">
            @if(is_string($icon) && !empty($icon))
                @svg($icon, 'w-5 h-5')
            @else
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/></svg>
            @endif
        </div>
    @endif

    <div class="flex-1 min-w-0">
        @if($title = $getTitle())
            <div class="font-medium text-gray-900">{{ $title }}</div>
        @endif
        @if($description = $getDescription())
            <div class="text-sm text-gray-500">{{ $description }}</div>
        @endif
    </div>

    @if($actions = $getActions())
        <div class="flex-shrink-0 flex items-center gap-2">
            @foreach($actions as $action)
                {!! is_object($action) && method_exists($action, 'toHtml') ? $action->toHtml() : $action !!}
            @endforeach
        </div>
    @endif
</div>
