<!-- markdown.blade.php -->
<textarea {!! $input->htmlAttributes([
    'rows' => Arr::get($input->field->config, 'rows', 10)
]) !!}>{{ $input->value }}</textarea>

{{ Assets::collection('styles')->add('/vendor/streams/ui/css/inputs/markdown.css') }}

<script>
    window.addEventListener('load', () => {
        window.streams.core.app.get('markdown')({
            element: document.getElementById("{{ $input->name() }}-input")
        });
    })
</script>
