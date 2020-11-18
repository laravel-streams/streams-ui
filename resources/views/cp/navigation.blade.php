<!-- navigation.blade.php -->
    @foreach ($cp->navigation->filter(function($section) {
        return !$section->parent;
    }) as $section)
    {!! $section->link([
        'class' => 'group flex items-center px-2 py-2 text-sm leading-5 font-medium rounded-md focus:outline-none transition ease-in-out duration-150 ' . ($section->active ? 'text-white' : 'text-white opacity-50')
    ]) !!}

    @php
        $children = $cp->navigation->children($section);
    @endphp

    @if ($children->isNotEmpty())
    <ul class="ml-2">
        @foreach ($children as $child)
            <li>
                {!! $child->link([
                    'class' => 'group flex items-center px-2 py-2 text-sm leading-5 font-medium rounded-md focus:outline-none transition ease-in-out duration-150 ' . ($child->active ? 'text-white' : 'text-white opacity-50')
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
