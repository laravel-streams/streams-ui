<!-- multiselect.blade.php -->
<select {!! $input->htmlAttributes() !!}>
@foreach ($input->field->config['options'] as $key => $value)
    <option {{ in_array($key, $input->value) ? 'selected' : null }} value="{{ $key }}">{{ $value }}</option>
@endforeach
</select>
