<!-- slug.blade.php -->
<div x-data="{value: '{{ $input->field->value }}'}">

    <input {!! $input->htmlAttributes([
        'type' => 'text',
    ]) !!}    
    x-model="value"
    x-on:keyup="value = String(value).toLowerCase()">

</div>
