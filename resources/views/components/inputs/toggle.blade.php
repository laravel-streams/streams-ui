{{-- Presentational switch for direct <x-ui::inputs.toggle wire:model="..." /> usage. --}}
<button
    x-data="{ state: false }"
    x-modelable="state"
    x-bind:aria-checked="(!! state).toString()"
    x-on:click="state = ! state"
    x-bind:class="!! state ? 'bg-primary-600' : 'bg-gray-200'"
    {{
        $attributes
            ->merge([
                'aria-checked' => 'false',
                'role' => 'switch',
                'type' => 'button',
            ], escape: false)
            ->class([
                'relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent outline-none transition-colors duration-200 ease-in-out',
                'disabled:pointer-events-none disabled:opacity-70',
            ])
    }}
>
    <span
        class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
        x-bind:class="{
            'translate-x-5 rtl:-translate-x-5': !! state,
            'translate-x-0': ! state,
        }"
    ></span>
</button>
