<div x-data="{open: false}" class="relative">

    <div x-on:click="open=!open">
        {!! view('ui::support.components', [
        'component' => $this,
        'name' => 'toggle',
        ]) !!}
    </div>

    <div x-show="open" class="absolute">
        {!! $slot ?? view('ui::support.components', [
        'component' => $this,
        ]) !!}
    </div>

</div>
