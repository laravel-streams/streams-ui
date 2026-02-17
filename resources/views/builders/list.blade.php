<div
    @if($list->getId()) id="{{ $list->getId() }}" @endif
    {!! $list->getHtmlAttributeBag() !!}
    {{ $attributes->class('flex flex-col space-y-4') }}
>
    @foreach ($list->getItems() as $item)
        @if(is_object($item) && method_exists($item, 'toHtml'))
            {!! $item->toHtml() !!}
        @elseif(is_array($item))
            <div class="flex items-center justify-center py-4 px-6 bg-gray-50 rounded-md">
                @if(isset($item['title']))
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-900">{{ $item['title'] }}</h3>
                        @if(isset($item['description']))
                            <p class="text-sm text-gray-500">{{ $item['description'] }}</p>
                        @endif
                    </div>
                @endif
                @if(isset($item['actions']))
                    <div class="flex space-x-2">
                        @foreach($item['actions'] as $action)
                            {!! $action !!}
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="flex items-center justify-center py-4 px-6 bg-gray-50 rounded-md">
                {{ $item }}
            </div>
        @endif
    @endforeach

    @if(empty($list->getItems()))
        <div class="flex items-center justify-center py-8 text-gray-500">
            No items to display
        </div>
    @endif
</div>
