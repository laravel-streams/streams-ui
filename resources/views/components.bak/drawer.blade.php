<div x-data="{open: false}" x-show="open" x-on:keydown.escape.window="open=!open"
    class="fixed justify-end inset-0 flex backdrop-blur-sm">

    <div
        class="absolute inset-0 bg-black opacity-75"
        x-on:click="open=false"
        x-show="open">
    </div>

    <div x-show="open" class="bg-white inset-0 w-1/3 transform">
        {{-- {!! $slot ?? view('ui::support.components', [
        'component' => $component,
        ]) !!} --}}
    </div>
</div>
