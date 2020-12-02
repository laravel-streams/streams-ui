<!-- toggle.blade.php -->
<label class="inline-flex items-center mt-3">
    <input {!! $input->htmlAttributes([
        'type' => 'chckbox',
        'class' => 'h-4 w-4 rounded border-gray-300 focus:border-indigo-300 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50 text-indigo-500',
        'checked' => ($input->field->value),
    ]) !!} checked><span class="ml-2 text-gray-700">Toggle</span>
</label>
