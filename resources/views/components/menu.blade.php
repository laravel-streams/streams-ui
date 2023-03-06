<div>
    <menu {!! $component->htmlAttributes() !!}>
        @foreach($component->items as $item)
        <li>
            @ui(Arr::pull($item, 'component'), $item)
        </li>
        @endforeach
    </menu>
</div>
