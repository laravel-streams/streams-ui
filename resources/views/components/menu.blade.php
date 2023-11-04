<div {!! $this->htmlAttributes() !!}>
    <menu>
        @foreach($this->items as $item)
        <li>
            @livewire(Arr::pull($item, 'component'), $item)
        </li>
        @endforeach
    </menu>
</div>
