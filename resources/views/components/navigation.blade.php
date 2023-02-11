<div @class([
    'flex-grow' => $this->getName() == 'streams.ui.components.admin.admin-menu',
])>
    <nav>
        <ul {!! $component->htmlAttributes() !!}>
            @foreach($component->items as $item)
            <li>

                @if(isset($item['anchor']))
                @php
                    if (in_array($item['anchor']['url'], [
                        Request::url(),
                    ])) {
                        $item['anchor']['attributes']['class'] = 'font-bold';
                    }
                @endphp
                @livewire('anchor', $item['anchor'])
                @endif

                @if(isset($item['image']))
                <img src="{{ $item['image']['src'] }}" {!! Html::attributes($item['image']['httributes'] ?? []) !!}
                             class="rounded-full h-10 w-10">
                @endif

            </li>
            @endforeach
        </ul>
    </nav>
</div>
