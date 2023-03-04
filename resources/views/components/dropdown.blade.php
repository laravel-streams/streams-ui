<div>
    <div x-data="{open: false}">

        @ui('button', $component->button)
        
        <div x-show="open">
            {!! $slot ?? view('ui::support.components', [
                'component' => $component,
            ]) !!}
        </div>

    </div>
</div>
