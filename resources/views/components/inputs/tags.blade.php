<div>

    @php
        $base = 'https://cdn.jsdelivr.net/npm/@yaireo/tagify';
    @endphp

    {{-- This needs tucked away. --}}
    <script src="{{ $base }}"></script>
    <script src="{{ $base }}/dist/tagify.polyfills.min.js"></script>
    <link href="{{ $base }}/dist/tagify.css" rel="stylesheet" type="text/css" />
    
    <input {!! $this->htmlAttributes([
        'type' => 'text',
        'name' => $this->name,
        'required' => $this->required,
        'readonly' => $this->readonly,
        'disabled' => $this->disabled,
        'placeholder' => $this->placeholder,
        'value' => implode(',', (array) $this->value),
    ]) !!}>

    <script>
        
        var input = document.querySelector('[name="{{ $this->name }}"]');

        new Tagify(input);
        
    </script>

</div>
