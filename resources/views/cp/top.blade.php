<!-- top.blade.php -->
<nav  class="sticky top-0 z-20 px-8 h-16 bg-white dark:bg-black border-b-2 border-primary">
<div class="flex h-16 items-center">
    {{-- Hamburger
    <button
        class="px-4 border-r border-gray-200 text-gray focus:outline-none focus:bg-gray-100 focus:text-gray-600 md:hidden"
        aria-label="Open sidebar">
        <svg class="h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
        </svg>
    </button>
    --}}

    <div class="flex-grow">
        {!! $cp->buttons !!}
    </div>

    <div x-data="{}">

        <div class="ml-4 flex items-center md:ml-6">

            @foreach ($cp->shortcuts as $shortcut)
            @if ($shortcut->dropdown)
            <div class="ml-3 relative" x-data="{show: false}">

                <button {!! $shortcut->htmlAttributes([
                    'class' => 'block',
                ]) !!} @click="show == true ? show = false : show = true" @click.away="show = false">

                    @if ($shortcut->svg)
                    {{-- {!! $shortcut->svg !!} --}}
                    @elseif ($shortcut->icon)
                    {{ svg($shortcut->icon, ['class' => 'h-8 w-8 text-black dark:text-white']) }}
                    @elseif ($shortcut->image)
                    <img class="h-8 w-8 rounded-full" src="{{ $shortcut->image }}" alt="">
                    @elseif ($shortcut->text)
                    {{ $shortcut->text }}
                    @else
                    {{ $shortcut->handle }}
                    @endif

                </button>

                <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md border-2 border-primary z-10" x-show="show">
                    <div class="py-1 rounded-md bg-white dark:bg-black">
                        @foreach ($shortcut->dropdown as $item)
                        <a {!! Html::attributes($item['attributes']) !!}
                        class="block px-4 py-2 text-sm text-black dark:text-white hover:bg-black hover:text-white transition ease-in-out duration-150"
                        >{{ $item['text'] }}</a>
                        @endforeach
                    </div>
                </div>
                {{-- ---------------------------------- --}}

            </div>
            @else
            <button {!! $shortcut->htmlAttributes([
                'class' => 'ml-3',
            ]) !!}>
                @if ($shortcut->svg)
                {!! $shortcut->svg !!}
                @elseif ($shortcut->icon)
                {{ svg($shortcut->icon, ['class' => 'h-8 w-8 text-black dark:text-white']) }}
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
</nav>
