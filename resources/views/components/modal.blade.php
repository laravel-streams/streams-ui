<div x-data="{open: false}" x-show="open" x-on:keydown.escape.window="open=!open"
    class="fixed inset-0 flex justify-center items-center backdrop-blur-sm">

    <div
        class="absolute inset-0 bg-black opacity-75"
        x-on:click="open=false"
        x-show="open">
    </div>

    <div x-show="open" class="bg-white transform mx-auto w-1/2 max-w-lg">
        Testing{!! $slot ?? view('ui::support.content', [
        'component' => $component,
        ]) !!}
    </div>
</div>
