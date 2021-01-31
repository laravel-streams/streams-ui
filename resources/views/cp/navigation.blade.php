<!-- navigation.blade.php -->
<nav class="ls-cp__navigation">

    @foreach ($cp->navigation->filter(function($section) {
        return !$section->parent;
    }) as $section)
    {!! $section->link([
        'class' => ($section->active ? '--accent' : '')
    ]) !!}

    @php
        $children = $cp->navigation->children($section);
    @endphp

    @if ($children->isNotEmpty())
    <ul>
        @foreach ($children as $child)
            <li>
                {!! $child->link([
                    'class' => ($child->active ? '--accent' : '')
                ]) !!}
            </li>
        @endforeach
    </ul>        
    @endif

    @endforeach
</nav>
