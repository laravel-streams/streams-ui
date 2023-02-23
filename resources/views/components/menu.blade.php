<div @class([
    'flex-grow' => $this->getName() == 'streams.ui.components.admin.admin-menu',
])>
    <menu {!! $component->htmlAttributes() !!}>
        @foreach($component->items as $item)
        <li>
            @livewire(Arr::pull($item, 'component'), $item)
        </li>
        @endforeach
    </menu>
</div>
