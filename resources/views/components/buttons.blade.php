<div class="flex space-x-4">
    @foreach ($component->buttons as $button)
    @livewire('button', $button)
    @endforeach
</div>
