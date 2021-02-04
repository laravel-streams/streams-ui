<!-- checkboxes.blade.php -->
@foreach ($input->field->config['options'] as $key => $value)
<label for="{{ $input->field->handle }}-{{ $key }}-{{ $value }}">
    <input {!! $input->htmlAttributes([
        'id' => $input->field->handle . '-' . $key . '-' . $value,
        'checked' => in_array($key, $input->value),
        'value' => $key,
    ]) !!}> {{ $value }}
</label>    
@endforeach
</select>
