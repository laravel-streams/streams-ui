@php
    $icon = $item->isActive()
        ? ($item->getActiveIcon() ?: $item->getIcon())
        : $item->getIcon();
    $iconPosition = $item->getIconPosition() ?: 'before';
    $badge = $item->getBadge();
@endphp

@if ($icon && $iconPosition === 'before')
  <x-ui::icon :icon="$icon" @class(['size-5 shrink-0', $iconClass ?? null]) />
@endif

<span @class([$labelClass ?? null])>{{ $item->getLabel() }}</span>

@if ($icon && $iconPosition === 'after')
  <x-ui::icon :icon="$icon" @class(['size-5 shrink-0', $iconClass ?? null]) />
@endif

@if (filled($badge))
  <span @class(['ml-2', $badgeClass ?? null])>
    <x-ui::badge size="xs" :color="$item->getBadgeColor()">{{ $badge }}</x-ui::badge>
  </span>
@endif
