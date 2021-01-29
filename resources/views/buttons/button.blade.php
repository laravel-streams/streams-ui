<!-- button.blade.php -->
@if ($button->dropdown)
<div class="ls-buttons" x-data="{show: false}">

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

    {{ __($button->text) }}

    {!! $button->close() !!}
    
    <div class="ls-button__dropdown" x-show="show">
        <div>
            @foreach ($button->dropdown as $item)
            <a {!! Html::attributes($item['attributes']) !!}>{{ $item['text'] }}</a>
            @endforeach
        </div>
    </div>

</div>
@else

{!! $button->open() !!}
{{-- <i v-show="button.icon" :class="button.icon"></i> --}}
{{ __($button->text) }}
{!! $button->close() !!}
@endif
