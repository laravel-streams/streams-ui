@foreach ($input->field->config['options'] as $key => $value)
<label class="inline-flex items-center">
    <input type="radio" name="{{ $input->field->handle }}" class="form-radio {{ implode(' ', $input->classes) }}" {{ $key == $input->field->value ? 'checked' : null }} value="{{ $key }}"/> 
    <span class="ml-2">{{ $value }}</span>
</label><br>
@endforeach
