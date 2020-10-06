@section('navigation')
<nav class="flex-1 px-2 space-y-1">
    @foreach ($cp->navigation->filter(function($link) {
        return !$link->parent;
    }) as $key => $item)
    <x-streams::cp.navigation-link href="/ui/{{ $item->id }}/table" :link="$item" />
    @endforeach
</nav>
@show
