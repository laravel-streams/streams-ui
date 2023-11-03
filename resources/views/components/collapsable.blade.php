<div x-data="{open: false}">

    <div @click="open=!open">
        {{ $this->text }}
    </div>

    <div x-show="open">
        {{-- {!! $slot ?? view('ui::support.components', [
            'component' => $this,
        ]) !!} --}}
    </div>

</div>
