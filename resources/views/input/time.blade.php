<!-- time.blade.php -->
<input {!! $input->htmlAttributes([
    'type' => 'time',
    'value' => $input->field->value ? $input->field->value->format('H:i') : null
]) !!}/>
