@props(['filters'])

<form {{ $attributes->class(['grid gap-y-4']) }} wire:submit="resetPage">

    <div class="flex justify-between">
        <h4 class="font-semibold">
            Filters
        </h4>

        <button class="text-danger-500 font-semibold" wire:click="resetTableFilters">Clear</button>
    </div>

    @foreach ($filters as $filter)
        {!! $filter->render() !!}
    @endforeach
</form>
