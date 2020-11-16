<select name="{{ $input->field->handle }}" class="{{ implode(' ', $input->classes) }}">
@foreach ($input->field->config['options'] as $key => $value)
    <option {{ $key == $input->field->value ? 'selected' : null }} value="{{ $key }}">{{ $value }}</option>
@endforeach
</select>
