@props(['filters', 'tableName' => 'default'])

{{-- Filters apply via live wire:model; prevent Enter from submitting. --}}
<form {{ $attributes->class(['grid gap-y-4']) }} @submit.prevent>

    <div class="flex justify-between">
        <h4 class="font-semibold">
            Filters
        </h4>

        <button class="text-danger-500 font-semibold" wire:click="resetTableFilters('{{ $tableName }}')">Clear</button>
    </div>

    @foreach ($filters as $filter)
        {!! $filter->render() !!}
    @endforeach
</form>
