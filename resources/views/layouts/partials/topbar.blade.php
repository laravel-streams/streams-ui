@php
use Streams\Ui\Support\Facades\UI;
@endphp

<div x-data="{}" x-cloak class="z-20 flex w-full h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">


    <button x-data @click.prevent="$dispatch('toggle-navigation')" type="button"
        class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
        <span class="sr-only">Open sidebar</span>
        @svg('heroicon-o-bars-3', 'h-6 w-6')
    </button>


    <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true"></div>


    {{-- Topbar --}}
    <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">

        {{-- Brand --}}
        <div class="ui-brand flex h-16 lg:hidden shrink-0 items-center font-bold">
            <a href="{{ UI::getHomeUrl() }}" class="text-xl" title="Go to panel homepage.">
                @if ($logo = UI::currentPanel()->getFavicon())
                    <img src="{{ $logo }}" alt="{{ __(UI::getPanel()->getBrandName()) }} Logo">
                @else
                    {{ __(UI::getPanel()->getBrandName()) }}
                @endif
            </a>
        </div>
        {{-- EOF Brand --}}

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

            @if ($topNavigation)
            @include('ui::layouts.partials.navigation-top')
            @endif
        </div>
        
        <div class="flex items-center gap-x-4 lg:gap-x-6">

            @foreach (UI::currentPanel()->getActions() as $action)
            @if ($action->isVisible())
            {!! $action
                ->style('icon')
                ->toHtml() !!}
            @endif
            @endforeach

            {{-- Separator --}}
            <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10" aria-hidden="true"></div>

            {{-- Profile Dropdown --}}
            @if (UI::currentPanel()->getUserMenu())
            <div class="relative" x-data="{open: false}">

                <button x-on:click="open=!open" x-on:click.outside="open=false" x-on:keydown.escape.window="open=false" type="button"
                    class="-m-1.5 flex items-center p-1.5" id="user-menu-button" aria-expanded="false"
                    aria-haspopup="true">
                    <span class="sr-only">Open user menu</span>
                    {{-- @livewire('avatar', [
                    'src' => auth()->user()?->email,
                    'htmlAttributes' => [
                    'class' => 'h-10 w-10 rounded-full bg-gray-50',
                    ],
                    ]) --}}
                    <span class="flex items-center">
                        <span class="ml-4 font-semibold leading-6 text-gray-900" aria-hidden="true">{{ auth()->user()?->name }}</span>
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
                    @php
                        $url = url($item->getUrl());
                        $target = $item->shouldOpenInNewTab() ? '_blank' : '_self';
                        $navigate = $spaEnabled && $target == '_self' && Str::startsWith($url, URL::to('/'));
                    @endphp
                    <a href="{{ $url }}"
                        {{-- {{ $navigate ? 'wire:navigate' : '' }} --}}
                        target="{{ $target }}"
                        class="flex w-full items-center gap-2 whitespace-nowrap rounded-md p-2 transition-colors duration-75 outline-none disabled:pointer-events-none disabled:opacity-70 hover:bg-gray-50 focus-visible:bg-gray-50"
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
            {{-- EOF Profile Dropdown --}}

        </div>
    </div>
</div>
{{-- EOF Topbar --}}
