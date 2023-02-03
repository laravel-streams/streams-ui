<form ui:submit="submit" {!! $component->htmlAttributes() !!}>
    @if (isset($slot))
        {!! $slot !!}
    @else
        @foreach ($component->fields as $field)
            @ui('field', $field)
        @endforeach
        {{-- @ui('buttons', ['buttons' => $component->buttons]) --}}
    @endif
</form>
