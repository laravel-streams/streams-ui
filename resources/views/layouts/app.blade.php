<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    @include('ui::layouts.partials.head')
</head>

<body class="h-full">

    @php
    use Streams\Ui\Support\Facades\UI;
    @endphp

    <!-- Off-canvas -->
    <div x-data="{open: false}" x-cloak @open-navigation.window="open=true" class="relative z-50 lg:hidden"
        role="dialog" aria-modal="true">

        <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/80"></div>

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
                            {{ __(config('app.name')) }}
                        </a>
                    </div>

                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <ul role="list" class="-mx-2 space-y-1">

                                    {{-- @foreach(UI::currentPanel()->getNavigation() as
                                    $item)
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
                                    @endforeach --}}

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
                                <div @click="collapsed=!collapsed" class="flex items-center gap-x-3 px-2 py-2 cursor-pointer">
                                    <span class="flex-1 text-sm font-bold text-black">{{ $label
                                        }}</span>
                                    <button @click="collapsed=!collapsed" title="{{ $label }}" x-bind:aria-expanded="!collapsed" x-bind:class="{ '-rotate-180': collapsed }">
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

    <div class="lg:pl-72 h-full flex flex-col">

        {{-- Topbar --}}
        <div
            class="sticky top-0 z-40 flex w-full h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">

            {{-- Burget Menu --}}
            <button x-data @click.="$dispatch('open-navigation')" type="button"
                class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
                <span class="sr-only">Open sidebar</span>
                @svg('heroicon-o-bars-3', 'h-6 w-6')
            </button>
            {{-- EOF Burget Menu --}}

            <!-- Separator -->
            <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true"></div>

            <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">

                {{-- Search Form --}}
                <form class="relative flex flex-1" action="#" method="GET">
                    <label for="search-field" class="sr-only">Search</label>
                    @svg('heroicon-o-magnifying-glass', 'pointer-events-none absolute inset-y-0 left-0 h-full w-5
                    text-gray-400')
                    <input id="search-field"
                        class="block h-full w-full border-0 rounded-sm py-0 pl-8 pr-0 text-gray-900 placeholder:text-gray-400 focus:ring-2 sm:text-sm"
                        placeholder="Search..." type="search" name="search">
                </form>
                {{-- EOF Search Form --}}

                <div class="flex items-center gap-x-4 lg:gap-x-6">

                    {{-- Notifications Button --}}
                    <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
                        <span class="sr-only">View notifications</span>
                        @svg('heroicon-o-bell', 'h-6 w-6')
                    </button>
                    {{-- EOF Notifications Button --}}

                    <!-- Separator -->
                    <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10" aria-hidden="true"></div>

                    <!-- Profile dropdown -->
                    <div class="relative" x-data="{open: false}">

                        <button x-on:click="open=!open" x-on:keydown.escape.window="open=false" type="button"
                            class="-m-1.5 flex items-center p-1.5" id="user-menu-button" aria-expanded="false"
                            aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            {{-- @livewire('avatar', [
                            'src' => 'ryan@pyrocms.com',
                            'htmlAttributes' => [
                            'class' => 'h-10 w-10 rounded-full bg-gray-50',
                            ],
                            ]) --}}
                            <span class="hidden lg:flex lg:items-center">
                                <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">Ryan
                                    Thompson</span>
                                @svg('heroicon-o-chevron-down', 'ml-2 h-4 w-4 text-gray-400')
                            </span>
                        </button>

                        <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <a href="/admin/logout"
                                class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50" role="menuitem"
                                tabindex="-1" id="user-menu-item-1">Sign out</a>
                        </div>

                    </div>
                    <!-- EOF Profile dropdown -->

                </div>
            </div>
        </div>
        {{-- EOF Topbar --}}

        <main class="flex flex-grow w-full">
            {!! $slot !!}
        </main>

        <footer
            class="flex items-center w-full h-8 shrink-0 gap-x-4 border-t border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 lg:px-4">
            <div class="opacity-50 text-xs">
                {{ response_time() . ' s' }}&nbsp;|&nbsp;{{ memory_usage() }}
            </div>
        </footer>

    </div>

    @include('ui::layouts.partials.assets')

</body>

</html>
