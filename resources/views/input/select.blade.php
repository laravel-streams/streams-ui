<!-- select.blade.php -->
<select {!! $input->htmlAttributes([
    'type' => null,
]) !!}>
@foreach ($input->field->config['options'] as $key => $value)
    <option {{ $key == $input->field->value ? 'selected' : null }} value="{{ $key }}">{{ $value }}</option>
@endforeach
</select>
