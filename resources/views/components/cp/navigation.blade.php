<nav class="flex-1 px-2 space-y-1">
    @foreach ($cp->navigation->filter(function($link) {
        return !$link->parent;
    }) as $link)
    {!! $link->render() !!}
    @endforeach
</nav>
