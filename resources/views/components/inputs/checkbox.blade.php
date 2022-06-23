<input type="checkbox" {!! $input->htmlAttributes([
    'value' => true,
    'type' => 'checkbox',
    'checked' => ($input->value),
]) !!}>
