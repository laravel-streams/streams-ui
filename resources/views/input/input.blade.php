<!-- input.blade.php -->
<input type="{{ Arr::get($input->config, 'type') ?: 'text' }}" {!! $input->htmlAttributes() !!}>
