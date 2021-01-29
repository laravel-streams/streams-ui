<?php /** @var \Streams\Ui\Input\Markdown $input */ ?>

<!-- markdown.blade.php -->
<textarea {!! $input->htmlAttributes([
    'rows' => 10,
    'x-data' => "app.get('input.markdown')({$input->toJson()})",
    'x-init' => 'init()',
    'x-model' => 'value'
]) !!}></textarea>
