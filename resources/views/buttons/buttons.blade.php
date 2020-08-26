@foreach ($buttons as $button)

{!! $button->open() !!}
{{-- <i v-show="button.icon" :class="button.icon"></i> --}}
{{ $button->text }}
{!! $button->close() !!}
    
@endforeach
