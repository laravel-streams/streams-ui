@props([
    'indicators' => [],
])

@if ($indicators)
<div
    {{ $attributes->class(['fi-ta-filter-indicators flex items-start justify-between gap-x-3 bg-gray-50 px-3 py-1.5 sm:px-6']) }}
>
    <div class="flex flex-col gap-x-3 gap-y-1 sm:flex-row">
        <span
            class="whitespace-nowrap text-sm font-medium leading-6 text-gray-600"
        >Active filters:</span>

        <div class="flex flex-wrap gap-1.5">
            @foreach ($indicators as $label => $indicator)
                {{-- <x-ui::badge :color="$indicator->getColor()">
                    {{ $indicator->getLabel() }}

                    @if ($indicator->isRemovable())
                        <x-slot
                            name="deleteButton"
                            :label="__('ui::table.filters.actions.remove.label')"
                            wire:click="{{ $indicator->getRemoveLivewireClickHandler() }}"
                            wire:loading.attr="disabled"
                            wire:target="removeTableFilter"
                        ></x-slot>
                    @endif
                </x-ui::badge> --}}
                <x-ui::badge color="primary">
                    {{ $label }}

                    {{-- @if ($indicator->isRemovable())
                        <x-slot
                            name="deleteButton"
                            :label="__('ui::table.filters.actions.remove.label')"
                            wire:click="{{ $indicator->getRemoveLivewireClickHandler() }}"
                            wire:loading.attr="disabled"
                            wire:target="removeTableFilter"
                        ></x-slot>
                    @endif --}}
                </x-ui::badge>
            @endforeach
        </div>
    </div>

    <div class="mt-0.5">
        {{-- <x-ui::action
            color="gray"
            icon="heroicon-m-x-mark"
            size="sm"
            :tooltip="__('filament-tables::table.filters.actions.remove_all.tooltip')"
            wire:click="removeTableFilters"
            wire:target="removeTableFilters,removeTableFilter"
        /> --}}
    </div>
</div>
@endif
