---
title: Navigation
nav_title: Navigation
description: Navigation groups, items, and wiring resources into the sidebar.
section: packages
package: ui
order: 90
tags: [ui, navigation]
status: ready
---

Panel sidebar navigation comes from registered resources, pages, and explicit navigation configuration.

## Resource navigation

Set static properties on resource classes:

```php
protected static ?string $navigationGroup = 'Content';
protected static ?string $navigationLabel = 'Posts';
protected static ?string $navigationIcon = 'heroicon-o-document-text';
protected static ?int $navigationSort = 10;
```

Or override `getNavigationItems()` for full control.

## Panel navigation groups

```php
Panel::make('admin')
    ->navigationGroups([
        NavigationGroup::make('Content'),
        NavigationGroup::make('Settings'),
    ]);
```

## Navigation items

```php
use Streams\Ui\Builders\Navigation\NavigationItem;

Panel::make('admin')->navigationItems([
    NavigationItem::make('Dashboard')
        ->url('/admin')
        ->icon('heroicon-o-home'),
]);
```

## NavigationItem API

| Method | Purpose |
|--------|---------|
| `group()` | Assign to a group label |
| `icon()` | Icon name |
| `url()` | Link target |
| `sort()` | Sort order |
| `badge()` | Optional badge |
| `isActiveWhen()` | Active state closure |

## Related

- [Panels](/docs/ui/panels)
- [Resources](/docs/ui/resources)
