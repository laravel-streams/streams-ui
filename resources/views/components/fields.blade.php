<div>
    <div class="flex flex-col space-y-4">
        @foreach ($component->fields as $field)
        @livewire('field', $field)
        @endforeach
    </div>
</div>
