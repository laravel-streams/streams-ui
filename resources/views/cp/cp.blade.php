<!doctype html>
<html lang="en">

<head>
    @include('ui::cp/partials/head')
</head>

<body>

    <div class="h-screen flex overflow-hidden bg-gray-100">
        
        <!-- Static sidebar for desktop -->
        <div class="_hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64">

                <!-- Sidebar component, swap this element with another sidebar if you like -->
                <div class="flex flex-col flex-grow bg-black pb-4 overflow-y-auto">
                    <div class="mt-5 flex-1 flex flex-col">

                        @section('navigation')
                        <nav class="flex-1 px-2 space-y-1">
                            @foreach ($cp->navigation as $key => $item)
                            <a href="/ui/{{ $item->id }}/table"
                                class="group flex items-center px-2 py-2 text-sm leading-5 font-medium {{ $item->id == request()->segment(2) ? 'text-white' : '' }} rounded-md focus:outline-none transition ease-in-out duration-150">
                                {{ $item->title }}
                            </a>
                            @endforeach
                        </nav>
                        @show

                    </div>
                </div>

            </div>
        </div>

        {{-- Top Bar --}}
        <div class="flex flex-col w-0 flex-1 overflow-hidden">
            <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
                
                {{-- Hamburger --}}
                <button
                    class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-600 md:hidden"
                    aria-label="Open sidebar">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>

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
                        <button
                            class="p-1 text-gray-400 rounded-full hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:shadow-outline focus:text-gray-500"
                            aria-label="Notifications">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </button>


                        {{-- Profile dropdown --}}
                        <div class="ml-3 relative" x-data="{
                            show: false
                        }">

                            <div>
                                <button
                                    x-on:click="show == true ? show = false : show = true"
                                    x-on:blur="show = false"
                                    class="max-w-xs flex items-center text-sm rounded-full focus:outline-none focus:shadow-outline"
                                    id="user-menu" aria-label="User menu" aria-haspopup="true">
                                    <img class="h-8 w-8 rounded-full"
                                        src="https://source.unsplash.com/hoS3dzgpHzw/256x256" alt="">
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

            {{-- Main Wrapper --}}
            <main class="flex-1 relative overflow-y-auto focus:outline-none" tabindex="0">
                <div class="pt-2 pb-6 md:py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <h1 class="text-2xl font-semibold text-gray-900">Page Title</h1>
                    </div>
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        
                        @yield('content')
                        
                    </div>
                </div>
            </main>

        </div>
    </div>

    @include('ui::cp/partials/assets')

</body>

</html>
