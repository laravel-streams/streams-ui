@php
    use Streams\Ui\Support\Facades\UI;
@endphp

<!-- Off-canvas -->
<div x-data="{open: false}" x-cloak @open-navigation.window="open=true" x-on:keydown.escape.window="open=false"
class="relative z-50 lg:hidden" role="dialog" aria-modal="true">

<div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/80"></div>

<div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform"
    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full" class="fixed inset-0 flex">
    <div class="relative mr-16 flex w-full max-w-xs flex-1">

        <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
            <button @click="open=false" type="button" class="-m-2.5 p-2.5">
                <span class="sr-only">Close sidebar</span>
                @svg('heroicon-o-x-mark', 'h-6 w-6 text-white')
            </button>
        </div>

        <!-- Mobile Sidebar -->
        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">

            {{-- Brand --}}
            <div class="flex h-16 shrink-0 items-center font-bold">
                <a href="{{ URL::to('admin') }}" class="text-xl" title="Go to panel homepage.">
                    @if ($logo = UI::currentPanel()->getBrandLogo())
                        <img src="{{ $logo }}" alt="{{ __(UI::getPanel()->getBrandName()) }} Logo">
                    @else
                        {{ __(UI::getPanel()->getBrandName()) }}
                    @endif
                </a>
            </div>

            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul role="list" class="-mx-2 space-y-1">

                            @foreach(UI::currentPanel()->getNavigation() as $group)
                            <li x-data="{collapsed: false}">
                                @if ($label = $group->getLabel())
                                <div @click="collapsed=!collapsed"
                                    class="flex items-center gap-x-3 px-2 py-2 cursor-pointer">
                                    <span class="flex-1 text-sm font-bold text-black">{{ $label
                                        }}</span>
                                    <button @click="collapsed=!collapsed" title="{{ $label }}"
                                        x-bind:aria-expanded="!collapsed"
                                        x-bind:class="{ '-rotate-180': collapsed }">
                                        @svg('heroicon-o-chevron-up', 'h-4 w-4 text-gray-400')
                                    </button>
                                </div>
                                @endif
                                <ul x-show="!collapsed" role="list">
                                    @foreach ($group->getItems() as $item)
                                    <li>
                                        <a href="{{ $item->getUrl() }}"
                                            target="{{ $item->shouldOpenInNewTab() ? '_blank' : '_self' }}"
                                            class="{{ $item->isActive() ? 'bg-gray-50 text-primary-600' : 'text-gray-700 hover:text-primary-600 hover:bg-gray-50' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
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
        <!-- EOF Mobile Sidebar -->

    </div>
</div>
</div>
<!-- EOF Off-canvas -->
