<!-- textarea.blade.php -->
<textarea {!! $input->htmlAttributes([
    'type' => 'date',
    'rows' => '10',
    'value' => null,
]) !!}>{{ $input->value }}</textarea>
