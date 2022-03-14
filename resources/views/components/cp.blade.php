<ui-cp {{ $attributes->merge(['brand_mode' => $brandMode]) }}>
    <x-ui::cp.sidebar slot="sidebar">
        {{ $sidebar ?? '' }}
    </x-ui::cp.sidebar>
    <x-ui::cp.header slot="header">
        {{ $header ?? '' }}
    </x-ui::cp.header>

    {{ $slot }}

</ui-cp>
