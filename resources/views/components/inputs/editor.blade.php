<script src="https://cdn.jsdelivr.net/gh/maxeckel/alpine-editor@0.3.1/dist/alpine-editor.min.js"></script>

<div x-data="{
        content: '{{ $input->value }}'
    }" class="bg-gray-200 border border-gray-900">
    <alpine-editor x-model="content" data-h1-classes="text-xl">
        <div data-type="menu">
            <button type="button" data-command="strong" data-active-class="bg-blue-400" class="bg-gray-500">
                Bold
            </button>
            <button type="button" data-command="em" data-active-class="bg-blue-400" class="bg-gray-500">
                Emphasize
            </button>
            <button type="button" data-command="code" data-active-class="bg-blue-400" class="bg-gray-500">
                Code
            </button>
            <button type="button" data-command="heading" data-level="1" data-active-class="bg-blue-400"
                class="bg-gray-500">
                H1
            </button>
        </div>

        <div data-type="editor" class="p-2"></div>

    </alpine-editor>

</div>
