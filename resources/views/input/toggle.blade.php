<!-- toggle.blade.php -->
<label class="inline-flex items-center mt-3">
    <input {!! $input->htmlAttributes([
        'type' => 'checkbox',
        'checked' => ($input->field->value),
    ]) !!} checked><span class="ml-2 text-gray-700">Toggle</span>
</label>
