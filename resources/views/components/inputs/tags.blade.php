<div>

    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

    <input {!! Html::attributes(
        array_filter([
            'type' => 'text',
            'id' => $component->id,
            'name' => $component->name,
            'required' => $component->required,
            'readonly' => $component->readonly,
            'disabled' => $component->disabled,
            'placeholder' => $component->placeholder,
            'value' => implode(',', (array) $component->value),
        ])
    ) !!}>

    <script>
        
        var input = document.querySelector('#{{ $component->id }}');

        new Tagify(input);
        
    </script>
</div>
