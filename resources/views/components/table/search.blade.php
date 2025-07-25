@props([
    // 'placeholder' => __('ui-tables::table.fields.search.placeholder'),
    'placeholder' => 'Search',
    'wireModel' => 'tableSearch',
])

@if ($this->table->getSearchableColumns())    
<div
    x-id="['input']"
    {{ $attributes->class(['ui-table-search-field']) }}
>
    {{-- <label x-bind:for="$id('input')" class="sr-only">
        {{ __('ui-tables::table.fields.search.label') }}
    </label> --}}

    {{-- <x-ui::input.wrapper
        inline-prefix
        prefix-icon="heroicon-m-magnifying-glass"
        prefix-icon-alias="tables::search-field"
        :wire:target="$wireModel"
    > --}}
        <x-ui::inputs.input
            autocomplete="off"
            {{-- inline-prefix --}}
            :placeholder="$placeholder . '...'"
            type="search"
            class="border-none"
            {{-- prefix-icon="heroicon-m-magnifying-glass" --}}
            :wire:model.live.debounce.500ms="$wireModel"
            {{-- x-bind:id="$id('input')"
            :wire:key="$this->getId() . '.table.' . $wireModel . '.field.input'" --}}
        />
    {{-- </x-ui::input.wrapper> --}}
</div>
@else
<div></div>
@endif
