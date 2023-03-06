<div x-data="{open: false}" x-show="open" x-on:keydown.escape.window="open=!open" class="fixed top-0 left-0 h-full w-full flex justify-center items-center backdrop-blur-sm">
    
    <div x-show="open" class="fixed inset-0 transform" x-on:click="open=false">
        <div class="absolute inset-0 bg-black opacity-75"></div>
    </div>
 
    <div x-show="open" class="bg-white transform mx-auto w-1/2 max-w-lg">
        {!! $slot ?? view('ui::support.content', [
            'component' => $component,
        ]) !!}
    </div>
</div>
