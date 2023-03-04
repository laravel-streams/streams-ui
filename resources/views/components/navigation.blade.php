<div @class([
    'flex-grow' => $this->getName() == 'streams.ui.components.admin.admin-menu',
])>
    <nav>
        <ul {!! $component->htmlAttributes() !!}>
            @foreach($component->items as $item)
            <li @class([
                'font-bold' => $item['active'] ?? false,
            ])>
                @ui(Arr::pull($item, 'component'), $item)
            </li>
            @endforeach
        </ul>
    </nav>
</div>
