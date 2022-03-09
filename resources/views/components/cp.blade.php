<ui-cp {{ $attributes->merge(['brand_mode' => $brandMode]) }}>
    <x-ui::cp-sidebar slot="sidebar">
        {{ $sidebar ?? '' }}
    </x-ui::cp-sidebar>
    <x-ui::cp-topbar slot="topbar">
        {{ $topbar ?? '' }}
    </x-ui::cp-topbar>

    {{ $slot }}


</ui-cp>
