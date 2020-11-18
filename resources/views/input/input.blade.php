<!-- input.blade.php -->
<input {!! $input->htmlAttributes([
    'type' => Arr::get($input->config, 'type') ?: 'text'
]) !!}>
