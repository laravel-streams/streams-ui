<!-- button.blade.php -->
@if ($button->dropdown)
<div class="c-dropdown" x-data="{show: false}">

    {!! $button->open([
        'x-on:click' => 'show == true ? show = false : show = true; return false;',
        'x-on:click.away' => 'show = false',
    ]) !!}
    
    @if ($button->svg)
    {!! $button->svg !!}
    @endif

    @if ($button->icon)
    <x-{{ $button->icon }}/>
    @endif

    <span>{{ __($button->text) }}</span>

    {!! $button->close() !!}
    
    <div class="c-dropdown__content" x-show="show">
        <div>
            @foreach ($button->dropdown as $item)
            <a {!! Html::attributes($item['attributes']) !!}><span>{{ $item['text'] }}</span></a>
            @endforeach
        </div>
    </div>

</div>
@else

{!! $button->open() !!}
{{-- <i v-show="button.icon" :class="button.icon"></i> --}}
{{ __($button->text) }} 
@if (isset($button->attributes['data-keymap']))
    <span class="hud-only -keymap">{{ $button->attributes['data-keymap'] }}</span>
@endif
{!! $button->close() !!}
@endif
