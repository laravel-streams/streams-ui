<x-ui::field :field="$field" class="flex">
    @foreach ($field->getComponents() as $component)
    @if (is_string($component))
        @livewire($component)
    @else
        {!! $component->render() !!}
    @endif
    @endforeach
</x-ui::field>
