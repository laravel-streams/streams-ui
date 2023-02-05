<div>

    {{-- This needs tucked away. --}}
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

    <input {!! $component->htmlAttributes([
            'type' => 'text',
            'name' => $component->name,
            'required' => $component->required,
            'readonly' => $component->readonly,
            'disabled' => $component->disabled,
            'placeholder' => $component->placeholder,
            'value' => implode(',', (array) $component->value),
    ]) !!}>

    <script>
        
        var input = document.querySelector('[name="{{ $component->name }}"]');

        new Tagify(input);
        
    </script>

</div>
