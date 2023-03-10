<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
<script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>

<div x-data="{
    init() {
        let target = this.$refs.editor;

        let editor = new EasyMDE({ element: target })
 
        editor.value(target.value);
 
        editor.codemirror.on('change', function() {
            target.value = editor.value();
        });
    }
}" class="prose">
    <textarea {!! $component->htmlAttributes([
        'x-ref' => 'editor',
        ]) !!}>{{ $component->value }}</textarea>
</div>
