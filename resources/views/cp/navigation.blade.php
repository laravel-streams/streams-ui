
<!-- navigation.blade.php -->
<nav class="flex-1 px-2 space-y-1">

    @foreach ($cp->navigation->filter(function($section) {
        return !$section->parent;
    }) as $section)
    {!! $section->link([
        'class' => 'group flex items-center px-2 py-2 text-sm font-medium rounded-md hover:text-white hover:bg-gray-900 ' . ($section->active ? 'text-white' : 'text-white opacity-50')
    ]) !!}

    @php
        $children = $cp->navigation->children($section);
    @endphp

    @if ($children->isNotEmpty())
    <ul class="ml-2">
        @foreach ($children as $child)
            <li>
                {!! $child->link([
                    'class' => 'grgroup flex items-center px-2 py-2 text-sm font-medium rounded-md hover:text-white hover:bg-gray-900 ' . ($child->active ? 'text-white' : 'text-white opacity-50')
                ]) !!}

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
