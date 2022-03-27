<div class="c-dropdown" x-data="{show: false}">

    {!! $dropdown->button([
        'x-on:click' => 'show == true ? show = false : show = true; return false;',
        'x-on:click.away' => 'show = false',
    ])->open() !!}
    
    @if ($button->svg)
    {!! $button->svg !!}
    @endif

    @if ($button->icon)
    {{-- <x-{{ $button->icon }}/> --}}
    @endif

    <span>{{ __($button->text()) }}</span>

    {!! $button->close() !!}
    
    <div class="c-dropdown__content" x-show="show">
        <div>
            @foreach ($button->dropdown as $item)
            <a {!! Html::attributes($item['attributes']) !!}><span>{{ $item['text'] }}</span></a>
            @endforeach
        </div>
    </div>

</div>
