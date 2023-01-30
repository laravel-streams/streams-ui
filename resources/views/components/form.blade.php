<form>
    @if (isset($slot))
        {!! $slot !!}
    @else
        @livewire('fields', $component->fields)
    @endif
</form>
