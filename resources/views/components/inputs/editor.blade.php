<div>
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

        var id = '{{ $component->id }}-editor';

        require(["vs/editor/editor.main"], function () {
            let editor = monaco.editor.create(document.getElementById(id), {
                value: `{!! $component->value !!}`,
                language: '{{ $component->language ?: "html" }}',
                theme: 'vs-dark', // Use configured/system
            });
            document.getElementById(id).addEventListener('keyup', function() {
                document.querySelector('#{{ $component->id }} textarea').value = editor.getValue();
            });
        });
    </script>

    <div id="{{ $component->id }}-editor" style="min-height: 200px;"></div>

    <textarea hidden {!! $component->htmlAttributes() !!}>{!! $component->value !!}</textarea>

</div>