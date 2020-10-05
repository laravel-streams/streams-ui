@foreach ($input->field->config['options'] as $key => $value)
    <input type="radio" name="{{ $input->field->handle }}" class="{{ implode(' ', $input->classes) }}" {{ $key == $input->field->value ? 'selected' : null }} value="{{ $key }}"/> {{ $value }}
@endforeach
