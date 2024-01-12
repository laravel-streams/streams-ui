@php
    use Streams\Ui\Support\Facades\UI;
@endphp

<nav class="flex flex-1 flex-col">
    <ul role="list" class="flex flex-1 flex-col gap-y-7">

        <li>
            <ul role="list" class="-mx-2 space-y-1">
                @foreach(UI::currentPanel()->getNavigation() as $key => $group)
                <li x-data="{collapsed: $persist(true).as('Sidebar{{ $key }}navGroup_collapsed')}">
                    @if ($label = $group->getLabel())
                    <div @click="collapsed=!collapsed"
                        class="flex items-center gap-x-3 px-2 py-2 cursor-pointer">
                        @if ($icon = $group->getIcon())
                        @svg($icon, 'h-6 w-6 shrink-0')
                        @endif
                        <span class="flex-1 text-sm font-bold text-black">{{ $label
                            }}</span>
                        <button @click="collapsed=!collapsed" title="{{ $label }}"
                            x-bind:aria-expanded="!collapsed" x-bind:class="{ '-rotate-180': collapsed }">
                            @svg('heroicon-o-chevron-up', 'h-4 w-4 text-gray-400')
                        </button>
                    </div>
                    <ul x-show="!collapsed" role="list">
                        @foreach ($group->getItems() as $item)
                        <li>
                            <a href="{{ $item->getUrl() }}"
                                target="{{ $item->shouldOpenInNewTab() ? '_blank' : '_self' }}"
                                class="{{ $item->isActive() ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' }} group flex w-full items-center gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                @if ($label)
                                <div class="relative ml-1.5 h-3 w-3 flex items-center justify-center">
            
                                    {{-- <div class="absolute -bottom-1/2 top-1/2 w-px bg-gray-300"></div> --}}
                                        
                                    <div class="relative h-1.5 w-1.5 rounded-full {{ $item->isActive() ? 'bg-current' : 'bg-gray-400' }}"></div>
                                </div>
                                @endif
                                @if ($icon = $item->getIcon())
                                @svg($icon, 'h-6 w-6 shrink-0')
                                @endif
                                {{ __($item->getLabel()) }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    @foreach ($group->getItems() as $item)
                    <a href="{{ $item->getUrl() }}"
                        target="{{ $item->shouldOpenInNewTab() ? '_blank' : '_self' }}"
                        class="{{ $item->isActive() ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' }} group flex w-full items-center gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        @if ($label)
                        <div class="relative ml-1.5 h-3 w-3 flex items-center justify-center">
    
                            {{-- <div class="absolute -bottom-1/2 top-1/2 w-px bg-gray-300"></div> --}}
                                
                            <div class="relative h-1.5 w-1.5 rounded-full {{ $item->isActive() ? 'bg-current' : 'bg-gray-400' }}"></div>
                        </div>
                        @endif
                        @if ($icon = $item->getIcon())
                        @svg($icon, 'h-6 w-6 shrink-0')
                        @endif
                        {{ __($item->getLabel()) }}
                    </a>
                    @endforeach
                    @endif
                </li>
                @endforeach
            </ul>
        </li>

    </ul>
</nav>
