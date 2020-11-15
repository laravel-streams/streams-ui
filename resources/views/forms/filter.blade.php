<!-- filter.blade.php -->
<input {!! $fieldType->htmlAttributes([
    'type' => $fieldType->config('type', 'text'),
    'value' => $fieldType->value,
]) !!}>
