<div {!! $component->htmlAttributes() !!}>
    @ui('input', [
        'name' => 'filter_' . $component->handle,
        'value' => Request::get('filter_' . $component->handle),
    ])
</div>
