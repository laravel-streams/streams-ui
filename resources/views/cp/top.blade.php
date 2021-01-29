<!-- top.blade.php -->
<nav class="ls-cp__topbar">
    
    <div class="ls-cp__buttons">
        {!! $cp->buttons !!}
    </div>

    <div class="ls-cp__shortcuts" x-data="{}">

        @foreach ($cp->shortcuts as $shortcut)
        @if ($shortcut->dropdown)
        <div x-data="{show: false}">

            <button {!! $shortcut->htmlAttributes() !!}
                @click="show == true ? show = false : show = true"
                @click.away="show = false">

                @if ($shortcut->svg)
                {{-- {!! $shortcut->svg !!} --}}
                @elseif ($shortcut->icon)
                {{ svg($shortcut->icon) }}
                @elseif ($shortcut->image)
                <img class="h-8 w-8 rounded-full" src="{{ $shortcut->image }}" alt="">
                @elseif ($shortcut->text)
                {{ $shortcut->text }}
                @else
                {{ $shortcut->handle }}
                @endif

            </button>

            <div class="ls-cp__dropdown" x-show="show">
                <div>
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
</nav>
