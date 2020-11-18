<!-- radio.blade.php -->
@foreach ($input->field->config['options'] as $key => $value)
<label class="inline-flex items-center">
    <input {!! $input->htmlAttributes([
        'type' => 'radio',
        'value' => $key,
        $input->field->value ? 'checked' : null,
    ]) !!}/> 
    <span class="ml-2">{{ $value }}</span>
</label><br>
@endforeach
