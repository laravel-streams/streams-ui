<div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">

    {{-- Hamburger --}}
    <button
        class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-600 md:hidden"
        aria-label="Open sidebar">
        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
        </svg>
    </button>

    <div class="flex px-4 items-center">
        {!! $cp->buttons !!}
    </div>

    <div class="flex-1 px-4 flex justify-between">
        <div class="flex-1 flex">
            {{-- <form class="w-full flex md:ml-0" action="#" method="GET">
                <label for="search_field" class="sr-only">Search</label>
                <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />
                    </svg>
                    </div>
                    <input id="search_field" class="block w-full h-full pl-8 pr-3 py-2 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 sm:text-sm" placeholder="Search" type="search">
                </div>
                </form> --}}
        </div>
        <div class="ml-4 flex items-center md:ml-6">

            {{-- Notifications --}}
            @foreach ($cp->shortcuts as $shortcut)
            <button
                {!! $shortcut->htmlAttributes([
                    'classes' => ['p-1 text-gray-400 rounded-full hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:shadow-outline focus:text-gray-500']
                ]) !!}
                aria-label="{{ $shortcut->title }}">
                @if ($shortcut->svg)
                {!! $shortcut->svg !!}
                @elseif ($shortcut->icon)
                <x-{{ $shortcut->icon }}/>
                @elseif ($shortcut->image)
                <img class="h-8 w-8 rounded-full" src="{{ $shortcut->image }}" alt="">
                @else
                {{ $shortcut->handle }}
                @endif
            </button>
            @endforeach

            {{-- Profile dropdown --}}
            <div class="ml-3 relative" x-data="{
                    show: false
                }">

                <div>
                    <button x-on:click="show == true ? show = false : show = true" x-on:blur="show = false"
                        class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:shadow-outline"
                        id="user-menu" aria-label="User menu" aria-haspopup="true">
                        <img class="h-8 w-8 rounded-full" src="https://source.unsplash.com/hoS3dzgpHzw/256x256" alt="">
                    </button>
                </div>

                {{-- Dropdown --}}
                {{-- ---------------------------------- --}}
                <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg" x-show="show">
                    <div class="py-1 rounded-md bg-white shadow-xs" role="menu" aria-orientation="vertical"
                        aria-labelledby="user-menu">
                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150"
                            role="menuitem">Your Profile</a>

                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150"
                            role="menuitem">Settings</a>

                        <a href="#"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150"
                            role="menuitem">Sign out</a>
                    </div>
                </div>
                {{-- ---------------------------------- --}}

            </div>

        </div>
    </div>
</div>
