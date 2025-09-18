@props([
    'id' => null,
    'title' => null,
    'description' => null,
    'icon' => null,
    'actions' => [],
    'htmlAttributes' => null,
])

<div 
    @if($id) id="{{ $id }}" @endif
    @if($htmlAttributes) {{ $htmlAttributes }} @endif
    class="flex items-center py-4 px-6 bg-white border border-gray-200 rounded-md shadow-sm {{ $attributes->get('class', '') }}"
    {{ $attributes->except(['class']) }}
>
    @if($icon)
        <div class="flex-shrink-0 mr-4">
            @if(str_starts_with($icon, 'heroicon'))
                <x-dynamic-component :component="$icon" class="h-6 w-6 text-gray-400" />
            @else
                <i class="{{ $icon }} h-6 w-6 text-gray-400"></i>
            @endif
        </div>
    @endif

    <div class="flex-1 min-w-0">
        @if($title)
            <h3 class="text-sm font-medium text-gray-900 truncate">{{ $title }}</h3>
        @endif
        @if($description)
            <p class="text-sm text-gray-500 truncate">{{ $description }}</p>
        @endif
    </div>

    @if(!empty($actions))
        <div class="flex-shrink-0 ml-4 flex space-x-2">
            @foreach($actions as $action)
                @if(is_object($action) && method_exists($action, 'toHtml'))
                    {!! $action->toHtml() !!}
                @else
                    {!! $action !!}
                @endif
            @endforeach
        </div>
    @endif
</div>
