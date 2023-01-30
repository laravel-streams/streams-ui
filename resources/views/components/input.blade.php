<input {!! Html::attributes(
    array_filter([
        'name'=> $input->name,
        'type' => $input->type,
        'value' => $input->value,
        'minlength' => $input->min,
        'maxlength' => $input->max,
        'required' => $input->required,
        'readonly' => $input->readonly,
        'disabled' => $input->disabled,
        'placeholder' => $input->placeholder,
        'pattern' => trim($input->pattern, "//"),
    ])
) !!}>
