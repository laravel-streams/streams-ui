<div x-data="{open: false}">

    <div @click="open=!open">
        {{ $component->text }}
    </div>

    <div x-show="open">
        {!! $slot ?? view('ui::support.components', [
            'component' => $component,
        ]) !!}
    </div>

</div>
