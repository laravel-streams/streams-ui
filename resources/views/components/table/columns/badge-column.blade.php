<div>
    <x-ui::badge
        :color="$getColor()"
        :icon="$getIcon()"
    >{{ $getTitle() ?: $getLabel() }}</x-ui::badge>
</div>
