<div>
    <div x-data="{open: false}">

        <div x-on:click="open=!open">
            @ui(Arr::pull($component->toggle, 'component', 'anchor'), $component->toggle)
        </div>

        <div x-show="open">
            {!! $slot ?? view('ui::support.content', [
                'component' => $component,
            ]) !!}
        </div>

    </div>
</div>
