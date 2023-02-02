<form ui:submit="submit" {!! $component->attributes() !!}>
    @if (isset($slot))
        {!! $slot !!}
    @else
        @ui('fields', ['fields' => $component->fields])
        @ui('buttons', ['buttons' => $component->buttons])
    @endif
</form>
