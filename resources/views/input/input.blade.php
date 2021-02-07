<?php /** @var \Streams\Ui\Input\Input $input */ ?>

<!-- input.blade.php -->
<input {!! $input->htmlAttributes([
    'type' => Arr::get($input->config, 'type') ?: 'text'
]) !!}>
