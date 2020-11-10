<div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">

    {{-- Hamburger --}}
    <button
        class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:bg-gray-100 focus:text-gray-600 md:hidden"
        aria-label="Open sidebar">
        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
        </svg>
    </button>

    <div class="flex px-4 items-center justify-between">
        {!! $cp->buttons !!}
    </div>

    <div class="flex-1 px-4 flex justify-end">
        
        <div class="ml-4 flex items-center md:ml-6">

            @foreach ($cp->shortcuts as $shortcut)
            @if ($shortcut->dropdown)
            <div class="ml-3 relative" x-data="{show: false}">

                <button {!! Html::attributes($shortcut->attributes) !!} x-on:click="show == true ? show = false : show = true">
                
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

                <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg" x-show="show">
                    <div class="py-1 rounded-md bg-white shadow-xs">
                        @foreach ($shortcut->dropdown as $item)
                        <a {!! Html::attributes($item['attributes']) !!}
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150"
                        >{{ $item['text'] }}</a>
                        @endforeach
                    </div>
                </div>
                {{-- ---------------------------------- --}}

            </div>
            @else
            <button {!! $shortcut->htmlAttributes() !!}>
                
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
            @endif
            @endforeach
        </div>
        
    </div>
</div>
