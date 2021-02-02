<!-- navigation.blade.php -->
<nav class="ls-cp__navigation">

    @foreach ($cp->navigation->filter(function($section) {
        return !$section->parent;
    }) as $section)
    {!! $section->link([
        'class' => ($section->active ? '--active' : '')
    ]) !!}

    @php
        $children = $cp->navigation->children($section);
    @endphp

    @if ($children->isNotEmpty())
    <ul>
        @foreach ($children as $child)
            <li class="{{ $child->active ? '--has-active' : '' }}"">
                {!! $child->link([
                    'class' => ($child->active ? '--active' : '')
                ]) !!}
            </li>
        @endforeach
    </ul>        
    @endif

    @endforeach
</nav>
