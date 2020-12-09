
<!-- navigation.blade.php -->
<nav class="flex-1 p-2 space-y-1">

    @foreach ($cp->navigation->filter(function($section) {
        return !$section->parent;
    }) as $section)
    {!! $section->link([
        'class' => 'group flex items-center px-2 py-2 text-sm font-medium rounded-md ' . ($section->active ? 'text-accent' : 'text-black')
    ]) !!}

    @php
        $children = $cp->navigation->children($section);
    @endphp

    @if ($children->isNotEmpty())
    <ul class="ml-2">
        @foreach ($children as $child)
            <li>
                {!! $child->link([
                    'class' => 'grgroup flex items-center px-2 py-2 text-sm font-medium rounded-md ' . ($child->active ? 'text-accent' : 'text-black')
                ]) !!}
            </li>
        @endforeach
    </ul>        
    @endif

    @endforeach
</nav>
