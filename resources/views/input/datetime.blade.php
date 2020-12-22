<!-- datetime.blade.php -->
<input {!! $input->htmlAttributes([
    'type' => 'datetime-local',
    'value' => $input->field->value ? $input->field->value->format('Y-m-d\TH:i:s') : null
]) !!}/>
