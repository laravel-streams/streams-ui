<div x-data="{open: false}">

    <div @click="open=!open">
        {{ $component->text }}
    </div>

    <div x-show="open">
        {!! $slot ?? view('ui::support.content', [
            'component' => $component,
        ]) !!}
    </div>

</div>
