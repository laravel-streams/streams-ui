<form {!! $component->htmlAttributes([
    'action' => $component->action,
    'method' => $component->method,
    'enctype' => $component->enctype,
]) !!}>

    <input type="hidden" name="_id" value="{{ $component->id }}"/>
    
    {{ csrf_field() }}

    @if (isset($slot))
        {!! $slot !!}
    @else
        @foreach ($component->fields as $field)
            @ui('field', $field)
        @endforeach
        @if ($component->buttons)
        <div class="mt-4">
            @foreach ($component->buttons as $button)
            @ui('button', $button)
            @endforeach
            @endif
        </div>
    @endif
</form>
