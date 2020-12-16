<!-- decimal.blade.php -->
<input {!! $input->htmlAttributes([
    'type' => 'number',
    'step' => Arr::get($input->field->config, 'step', 0.1)
]) !!}>
