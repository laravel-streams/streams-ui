<div>
    <div x-data="{open: false}">

        @livewire('button', $component->button)
        
        <div x-show="open">
            {!! $slot ?? view('ui::support.components', [
                'component' => $component,
            ]) !!}
        </div>

    </div>
</div>
