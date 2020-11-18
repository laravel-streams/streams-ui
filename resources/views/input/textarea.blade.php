<!-- textarea.blade.php -->
<textarea {!! $input->htmlAttributes([
    'type' => 'date',
    'rows' => '10',
]) !!}>{{ $input->field->value }}</textarea>
