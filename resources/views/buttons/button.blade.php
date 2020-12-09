<!-- button.blade.php -->
@if ($button->dropdown)
<div class="inline-block relative" x-data="{show: false}">

    {!! $button->open([
        'x-on:click' => 'show == true ? show = false : show = true; return false;',
        'x-on:click.away' => 'show = false',
        'class' => 'py-1 px-3 text-sm font-bold text-black border-2 border-primary inline-block',
    ]) !!}
    
    @if ($button->svg)
    {!! $button->svg !!}
    @endif

    @if ($button->icon)
    <x-{{ $button->icon }}/>
    @endif

    {{ __($button->text) }}

    {!! $button->close() !!}
    
    <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md border-2 border-primary z-5" x-show="show">
        <div class="py-1 rounded-md bg-white">
            @foreach ($button->dropdown as $item)
            <a {!! Html::attributes($item['attributes']) !!}
            class="block px-4 py-2 text-sm text-black hover:bg-black hover:text-white transition ease-in-out duration-150"
            >{{ $item['text'] }}</a>
            @endforeach
        </div>
    </div>

</div>
@else

{!! $button->open([
    'class' => 'py-1 px-3 text-sm font-bold text-black border-2 border-primary inline-block',
]) !!}
{{-- <i v-show="button.icon" :class="button.icon"></i> --}}
{{ __($button->text) }}
{!! $button->close() !!}
@endif
