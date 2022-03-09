<ui-cp {{$attributes->merge(['brand_mode' => $brandMode, 'style' => 'overflow: visible; flex-direction: row;'])}}>
    <div slot="sidebar"  style=""> <!-- should be component too -->
        {{ $sidebar ?? '' }}
    </div>
    <div slot="topbar" class="o-cp__topbar" style="width: 20%">
        {{ $topbar ?? '' }}
    </div>
    <div class="o-cp__content">
        {{ $slot }}
    </div>

</ui-cp>
