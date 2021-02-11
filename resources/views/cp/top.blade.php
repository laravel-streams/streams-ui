<!-- top.blade.php -->
<div class="o-cp__topbar">
    <div class="c-topbar">
        
        <div class="c-topbar__buttons">
            {!! $cp->buttons !!}
        </div>

        <div class="c-topbar__shortcuts" x-data="{}">
            <div class="c-shortcuts">
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
        </div>

    </div>
</div>
