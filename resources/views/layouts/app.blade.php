<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">

<head>
    @include('ui::layouts.partials.head')
</head>

<body class="h-full">

    {{-- Off-canvas Menu --}}
    <div x-data="{open: true}" class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
        <!--
            Off-canvas menu backdrop, show/hide based on off-canvas menu state.
    
            Entering: "transition-opacity ease-linear duration-300"
            From: "opacity-0"
            To: "opacity-100"
            Leaving: "transition-opacity ease-linear duration-300"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div x-show="open" class="fixed inset-0 bg-gray-900/80"></div>

        <div x-show="open" class="fixed inset-0 flex">
            <!--
                Off-canvas menu, show/hide based on off-canvas menu state.
        
                Entering: "transition ease-in-out duration-300 transform"
                    From: "-translate-x-full"
                    To: "translate-x-0"
                Leaving: "transition ease-in-out duration-300 transform"
                    From: "translate-x-0"
                    To: "-translate-x-full"
            -->
            <div class="relative mr-16 flex w-full max-w-xs flex-1">
                <!--
                    Close button, show/hide based on off-canvas menu state.
        
                    Entering: "ease-in-out duration-300"
                    From: "opacity-0"
                    To: "opacity-100"
                    Leaving: "ease-in-out duration-300"
                    From: "opacity-100"
                    To: "opacity-0"
                -->
                <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                    <button :click="open = false" type="button" class="-m-2.5 p-2.5">
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
                    {{-- EOF Brand --}}

                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <ul role="list" class="-mx-2 space-y-1">

                                    @foreach(\Streams\Ui\Support\Facades\UI::currentPanel()->getNavigationItems() as $item)
                                    <li>
                                        <!-- Current: "bg-gray-50 text-indigo-600", Default: "text-gray-700 hover:text-indigo-600 hover:bg-gray-50" -->
                                        <a href="{{ url($item->url) }}"
                                            class="{{ url($item->url) == Request::url() ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                            @if ($item->icon)
                                                @svg($item->icon, 'h-6 w-6 shrink-0')
                                            @endif
                                            {{ __($item->text) }}
                                        </a>
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
    {{-- EOF Off-canvas Menu --}}

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
                            @foreach(\Streams\Ui\Support\Facades\UI::currentPanel()->getNavigationItems() as $item)
                            <li>
                                <!-- Current: "bg-gray-50 text-indigo-600", Default: "text-gray-700 hover:text-indigo-600 hover:bg-gray-50" -->
                                <a href="{{ url($item->url) }}"
                                    class="{{ url($item->url) == Request::url() ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                    @if ($item->icon)
                                        @svg($item->icon, 'h-6 w-6 shrink-0')
                                    @endif
                                    {{ __($item->text) }}
                                </a>
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
            <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
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
                    @svg('heroicon-o-magnifying-glass', 'pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400')
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
                        
                        <button x-on:click="open=!open" x-on:keydown.escape.window="open=false" type="button" class="-m-1.5 flex items-center p-1.5" id="user-menu-button"
                            aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            @livewire('avatar', [
                                'src' => 'ryan@pyrocms.com',
                                'htmlAttributes' => [
                                    'class' => 'h-10 w-10 rounded-full bg-gray-50',
                                ],
                            ])
                            <span class="hidden lg:flex lg:items-center">
                                <span class="ml-4 text-sm font-semibold leading-6 text-gray-900"
                                    aria-hidden="true">Ryan Thompson</span>
                                    @svg('heroicon-o-chevron-down', 'ml-2 h-4 w-4 text-gray-400')
                            </span>
                        </button>

                        <!--
                            Dropdown menu, show/hide based on menu state.
            
                            Entering: "transition ease-out duration-100"
                            From: "transform opacity-0 scale-95"
                            To: "transform opacity-100 scale-100"
                            Leaving: "transition ease-in duration-75"
                            From: "transform opacity-100 scale-100"
                            To: "transform opacity-0 scale-95"
                        -->
                        <div x-show="open" x-cloak class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                            tabindex="-1">
                            <!-- Active: "bg-gray-50", Not Active: "" -->
                            <a href="/admin/logout" class="block px-3 py-1 text-sm leading-6 text-gray-900" role="menuitem"
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

        <footer class="flex items-center w-full h-8 shrink-0 gap-x-4 border-t border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 lg:px-4">
            <div class="opacity-50 text-xs">
                {{ response_time() . ' s' }}&nbsp;|&nbsp;{{ memory_usage() }}
            </div>
        </footer>

    </div>

    @include('ui::layouts.partials.assets')

</body>

</html>
