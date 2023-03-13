<div {!! $component->htmlAttributes() !!}>
    <ul>
        @foreach($component->items as $item)
        <li>
            @ui(Arr::pull($item, 'component'), $item)
        </li>
        @endforeach
    </ul>
</div>
