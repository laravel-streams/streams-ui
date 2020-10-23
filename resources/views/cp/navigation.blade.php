<nav class="flex-1 px-2 space-y-1">
    @foreach ($cp->navigation->filter(function($link) {
        return !$link->parent;
    }) as $link)
    {!! $link->render() !!}

    @php
        $children = $cp->navigation->children($link);
    @endphp

    @if ($children->isNotEmpty())
    <ul class="ml-2">
        @foreach ($children as $child)
            <li>
                {!! $child->render() !!}

                <ul>
                    @foreach ($child->buttons as $button)
                        <li>{!! $button->render() !!}</li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>        
    @endif

    @endforeach
</nav>
