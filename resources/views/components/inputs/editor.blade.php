<script type="text/javascript" src="https://unpkg.com/monaco-editor@latest/min/vs/loader.js"></script>
<script>
    require.config({ paths: { 'vs': 'https://unpkg.com/monaco-editor@latest/min/vs' }});

    // Before loading vs/editor/editor.main, define a global MonacoEnvironment that overwrites
    // the default worker url location (used when creating WebWorkers). The problem here is that
    // HTML5 does not allow cross-domain web workers, so we need to proxy the instantiation of
    // a web worker through a same-domain script
    window.MonacoEnvironment = {
        getWorkerUrl: function(workerId, label) {
            return `data:text/javascript;charset=utf-8,${encodeURIComponent(`
            self.MonacoEnvironment = {
                baseUrl: 'https://unpkg.com/monaco-editor@latest/min/'
            };
            importScripts('https://unpkg.com/monaco-editor@latest/min/vs/base/worker/workerMain.js');`
            )}`;
        }
    };

    require(["vs/editor/editor.main"], function () {
        let editor = monaco.editor.create(document.getElementById('editorjs'), {
            value: `{!! $input->value !!}`,
            language: '{{ $input->config("language", "html") }}', // Use field config
            theme: 'vs-dark', // Use configured/system
        });
        document.getElementById('editorjs').addEventListener('keyup', function() {
            document.querySelector('[name="{{ $input->name() }}"]').value = editor.getValue();
        });
    });
</script>

<div id="editorjs" style="height: 200px;"></div>

<textarea hidden {!! $input->htmlAttributes() !!}>{!! $input->value !!}</textarea>
