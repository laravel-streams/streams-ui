<ui-control-panel {{$attributes->class(['o-cp'])->merge(['brand_mode' => $brandMode])}}>
    <div slot="sidebar" class="o-cp__sidebar"> <!-- should be component too -->
        {{ $sidebar ?? '' }}
    </div>

    <div class="o-cp__topbar"> <!-- should be component too -->
        <div class="c-topbar">
            topbar
        </div>
    </div>

    <div class="o-cp__content">
        {{ $slot }}
    </div>

</ui-control-panel>
