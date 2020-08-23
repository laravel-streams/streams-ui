@foreach ($buttons as $button)

{!! $button->open([
    "href" => $button->attr("attributes.href"),
    "class" => ""
]) !!}
{{-- <i v-show="button.icon" :class="button.icon"></i> --}}
{{ $button->text }}
{!! $button->close() !!}
    
@endforeach
