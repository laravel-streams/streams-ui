@php
    use Streams\Ui\Support\Facades\UI;
@endphp

<!-- Sidebar -->
<div class="hidden fixed inset-y-0 lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
    <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 pb-4">

        {{-- Brand --}}
        <div class="flex h-16 shrink-0 items-center font-bold">
            <a href="{{ URL::to('admin') }}" class="text-xl" title="Go to panel homepage.">
                {{ __(config('app.name')) }}
            </a>
        </div>
        {{-- EOF Brand --}}

        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">

                <li>
                    <ul role="list" class="-mx-2 space-y-1">
                        @foreach(UI::currentPanel()->getNavigation() as $group)
                        <li x-data="{collapsed: false}">
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
                            @endif
                            <ul x-show="!collapsed" role="list">
                                @foreach ($group->getItems() as $item)
                                <li>
                                    <a href="{{ $item->getUrl() }}"
                                        target="{{ $item->shouldOpenInNewTab() ? '_blank' : '_self' }}"
                                        class="{{ $item->isActive() ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                        @if ($icon = $item->getIcon())
                                        @svg($icon, 'h-6 w-6 shrink-0')
                                        @endif
                                        {{ __($item->getLabel()) }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endforeach
                    </ul>
                </li>

            </ul>
        </nav>

    </div>
</div>
<!-- EOF Sidebar -->
