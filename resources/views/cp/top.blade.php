<!-- top.blade.php -->
<nav class="ls-cp__topbar">
    
    <div class="ls-cp__buttons">
        {!! $cp->buttons !!}
    </div>

    <div class="ls-cp__shortcuts" x-data="{}">

        @foreach ($cp->shortcuts as $shortcut)
        <div x-data="{show: false}">
        
            {!! $shortcut->open([
                '@click' => 'show == true ? show = false : show = true',
                '@click.away' => 'show = false',
            ]) !!}
                @if ($shortcut->svg)
                {!! $shortcut->svg !!}
                @elseif ($shortcut->icon)
                {{ svg($shortcut->icon) }}
                @elseif ($shortcut->image)
                <img src="{{ $shortcut->image }}" alt="">
                @elseif ($shortcut->text)
                {{ $shortcut->text }}
                @else
                {{ $shortcut->handle }}
                @endif
            {!! $shortcut->close() !!}

            @if ($shortcut->dropdown)
            <div class="ls-cp__dropdown" x-show="show">
                <div>
                    @foreach ($shortcut->dropdown as $item)
                    <a {!! Html::attributes(Arr::get(Arr::undot($item), 'attributes', [])) !!}>{{ $item['text'] }}</a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
        @endforeach

    </div>
</nav>
