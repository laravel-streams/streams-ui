<select {!! $input->htmlAttributes([
    'type' => null,
]) !!}>
@foreach ($input->options() as $key => $value)
    <option {{ $key == $input->value ? 'selected' : null }} value="{{ $key }}">{{ $value }}</option>
@endforeach
</select>
