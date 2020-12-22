<!-- date.blade.php -->
<input {!! $input->htmlAttributes([
    'type' => 'date',
    'value' => $input->field->value ? $input->field->value->format('Y-m-d') : null
]) !!}>
