---
title: Pages
nav_title: Pages
description: ListEntries, CreateEntry, EditEntry, and custom Livewire pages.
section: packages
package: ui
order: 80
tags: [ui, pages]
status: ready
---

**Pages** are Livewire components rendered inside a panel layout.

## Resource CRUD pages

| Class | Purpose |
|-------|---------|
| `ListEntries` | Table listing |
| `CreateEntry` | Create form |
| `EditEntry` | Edit form |

Namespace: `Streams\Ui\Livewire\Pages`

Register through resource `getPages()`:

```php
return [
    'index' => ListEntries::route('/'),
    'create' => CreateEntry::route('/create'),
    'edit' => EditEntry::route('/{entry}/edit'),
];
```

Each page sets `protected static string $resource = PostResource::class`.

## Custom pages

Extend `Streams\Ui\Livewire\Pages\PanelPage` for standalone screens:

```php
class DashboardPage extends PanelPage
{
    protected static string $view = 'ui::pages.dashboard';
    protected static ?string $navigationLabel = 'Dashboard';
}
```

Register on the panel:

```php
Panel::make('admin')->pages([DashboardPage::class]);
```

## Related

- [Resources](/docs/ui/resources)
- [Routing](/docs/ui/routing)
- [Livewire integration](/docs/ui/livewire)
