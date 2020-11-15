<!-- slug.blade.php -->
<div x-data="{value: '{{ $input->field->value }}'}">

    <input type="text" name="{{ $input->field->handle }}" value="{{ $input->field->value }}" class="{{ implode(' ', $input->classes) }}" 
    x-model="value"
    x-on:keyup="value = String(value).toLowerCase()">

</div>
