
<input {!! $input->htmlAttributes([
    'value' => $input->value ? date('Y-m-d', strtotime($input->value)) : null
]) !!}>
