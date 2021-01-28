<?php /** @var \Streams\Ui\Input\Markdown $input */ ?>

<!-- markdown.blade.php -->
<textarea {!! $input->htmlAttributes([
    'rows' => 10,
    'x-data' => "window.streams.core.app.get('input.markdown')({$input->toJson()})",
    'x-init' => 'init()',
    'x-model' => 'value'
]) !!}></textarea>
