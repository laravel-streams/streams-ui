<div>
    <div class="layout">
        @foreach ($component->content as $content)
        @livewire($content['type'], $content)
        @endforeach
    </div>
</div>
