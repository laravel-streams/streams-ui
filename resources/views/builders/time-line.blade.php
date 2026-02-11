@php
    $items = $timeLine->getItems();
    $mainTitle = $timeLine->getHtmlAttributes()['data-main-title'] ?? '';
@endphp

<div class="max-w-3xl mx-auto bg-white p-6">
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900">{{ $mainTitle }}</h2>
    </div>
    <div class="relative ">
        <div class="absolute left-3.5 top-2 bottom-2 w-px bg-gray-200"></div>
            @foreach($items as $item)
                <div class="relative flex gap-4">
                    <div class="absolute -top-4 left-0 right-0 flex justify-center">
                        <span class="bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600 rounded-full">
                            {{ $item['date'] }}
                        </span>
                    </div>
                    <div class="relative z-10 flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center bg-blue-100"
                        @switch($item['type'] ?? 'default')
                            @case('attendance')
                                border-red-500 bg-red-50
                                @break
                            @case('role')
                                border-purple-500 bg-purple-50
                                @break
                            @case('project')
                                border-green-500 bg-green-50
                                @break
                            @default
                                border-blue-500 bg-blue-50
                        @endswitch>

                        @if($item['icon'] ?? false)
                            @svg($item['icon'], 'w-4 h-4 text-current')
                        @else
                            <span class="w-2 h-2 rounded-full
                                @switch($item['type'] ?? 'default')
                                    @case('attendance') bg-red-500 @break
                                    @case('role') bg-purple-500 @break
                                    @case('project') bg-green-500 @break
                                    @default bg-blue-500
                                @endswitch
                            "></span>
                        @endif
                    </div>
                    <div class="flex-1 pb-6">
                        <span class="inline-block px-2 py-0.5 mb-1 text-xs font-semibold uppercase tracking-wide text-blue-700 bg-blue-50">
                            {{ $item['title'] }}
                        </span>
                        <p class="text-sm text-gray-900">
                            {{ $item['description'] }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $item['hour'] }}
                        </p>
                    </div>
                </div>
            @endforeach
    </div>
</div>



