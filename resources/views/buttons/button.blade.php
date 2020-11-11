@if ($button->dropdown)
<div class="inline-block relative" x-data="{show: false}">

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
    
    <div class="absolute left-0 w-48 rounded-md shadow-lg z-10" x-show="show">
        <div class="py-1 rounded-md bg-white shadow-xs">
            @foreach ($button->dropdown as $item)
            <a {!! Html::attributes($item['attributes']) !!}
            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150"
            >{{ $item['text'] }}</a>
            @endforeach
        </div>
    </div>
    {{-- ---------------------------------- --}}

</div>
@else
{!! $button->open() !!}
{{-- <i v-show="button.icon" :class="button.icon"></i> --}}
{{ __($button->text) }}
{!! $button->close() !!}
@endif
