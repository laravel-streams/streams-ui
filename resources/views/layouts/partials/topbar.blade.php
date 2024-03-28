@php
use Streams\Ui\Support\Facades\UI;
@endphp

{{-- Topbar --}}
<div
class="sticky top-0 z-40 flex w-full h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">

{{-- Burger Menu --}}
<button x-data @click.="$dispatch('open-navigation')" type="button"
    class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
    <span class="sr-only">Open sidebar</span>
    @svg('heroicon-o-bars-3', 'h-6 w-6')
</button>
{{-- EOF Burger Menu --}}

<!-- Separator -->
<div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true"></div>

<div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">

    {{-- Search Form --}}
    <div class="relative flex flex-1">

        @if ($topNavigation)
        <div class="flex h-16 shrink-0 items-center font-bold mr-12">
            <a href="{{ UI::getHomeUrl() }}" class="text-xl" title="Go to panel homepage.">
                @if ($logo = UI::currentPanel()->getBrandLogo())
                    <img src="{{ $logo }}" alt="{{ __(UI::getPanel()->getBrandName()) }} Logo">
                @else
                    {{ __(UI::getPanel()->getBrandName()) }}
                @endif
            </a>
        </div>
        @endif

        <!-- Separator -->
        {{-- <div class="hidden lg:block lg:h-6 mx-6 my-5 lg:w-px lg:bg-gray-900/10" aria-hidden="true"></div> --}}

        @if ($topNavigation)
        @include('ui::layouts.partials.navigation-top')
        @endif
        {{-- @include('ui::layouts.partials.search') --}}
    </div>
    {{-- <form class="relative flex flex-1" action="#" method="GET">
        <label for="search-field" class="sr-only">Search</label>
        @svg('heroicon-o-magnifying-glass', 'pointer-events-none absolute inset-y-0 left-0 h-full w-5
        text-gray-400')
        <input id="search-field"
            class="block h-full w-full border-0 rounded-sm py-0 pl-8 pr-0 text-gray-900 placeholder:text-gray-400 focus:ring-2 sm:text-sm"
            placeholder="Search..." type="search" name="search">
    </form> --}}
    {{-- EOF Search Form --}}

    <div class="flex items-center gap-x-4 lg:gap-x-6">

        {{-- 
            
            USER ACTIONS

        --}}
        {{-- <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
            <span class="sr-only">View notifications</span>
            @svg('heroicon-o-bell', 'h-6 w-6')
        </button> --}}

        <!-- Separator -->
        {{-- <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10" aria-hidden="true"></div> --}}

        <!-- Profile dropdown -->
        @if (UI::currentPanel()->getUserMenu())
        <div class="relative" x-data="{open: false}">

            <button x-on:click="open=!open" x-on:keydown.escape.window="open=false" type="button"
                class="-m-1.5 flex items-center p-1.5" id="user-menu-button" aria-expanded="false"
                aria-haspopup="true">
                <span class="sr-only">Open user menu</span>
                {{-- @livewire('avatar', [
                'src' => auth()->user()?->email,
                'htmlAttributes' => [
                'class' => 'h-10 w-10 rounded-full bg-gray-50',
                ],
                ]) --}}
                <span class="hidden lg:flex lg:items-center">
                    <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">{{ auth()->user()?->name }}</span>
                    @svg('heroicon-o-chevron-down', 'ml-2 h-4 w-4 text-gray-400')
                </span>
            </button>

            <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute min-w-[12rem] right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white p-1 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                @foreach (UI::currentPanel()->getUserMenu() as $item)
                <a href="{{ url($item->getUrl()) }}"
                    target="{{ $item->shouldOpenInNewTab() ? '_blank' : '_self' }}"
                    class="flex w-full items-center gap-2 whitespace-nowrap rounded-md p-2 text-sm transition-colors duration-75 outline-none disabled:pointer-events-none disabled:opacity-70 hover:bg-gray-50 focus-visible:bg-gray-50"
                    role="menuitem" tabindex="-1" id="user-menu-item-1">
                    @if ($icon = $item->getIcon())
                    @svg($icon, 'h-5 w-5 text-gray-500')
                    @endif
                    {{ __($item->getLabel()) }}
                </a>
                @endforeach
            </div>

        </div>
        @endif
        <!-- EOF Profile dropdown -->

    </div>
</div>
</div>
{{-- EOF Topbar --}}
