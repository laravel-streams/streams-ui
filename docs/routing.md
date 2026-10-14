---
title: 'UI: Routing'
nav_title: Routing
description: Panel route registration, route names, and custom routes closure.
section: packages
package: ui
order: 60
tags: [ui, routing]
status: ready
---

Panel routes register automatically when you call `UI::panel()`. Resource pages define paths relative to the resource slug.

## Route naming

Pattern: `streams.ui.{panelId}.{resourceSlug}.{pageName}`

```php
PostResource::getUrl('edit', ['entry' => $post->id]);
// streams.ui.admin.posts.edit
```

## Resource page routes

```php
public static function getPages(): array
{
    return [
        'index' => ListEntries::route('/'),
        'create' => CreateEntry::route('/create'),
        'edit' => EditEntry::route('/{entry}/edit'),
    ];
}
```

## Panel path prefix

```php
Panel::make('admin')->path('admin');
// /admin/posts, /admin/posts/create, ...
```

## Custom routes

Pass a closure to `->routes()` on the panel:

```php
Panel::make('admin')
    ->path('admin')
    ->routes(function () {
        Route::get('/settings', SettingsPage::class);
    });
```

## Standalone pages

Register page classes on the panel:

```php
Panel::make('admin')->pages([DashboardPage::class]);
```

Standalone pages extend `Streams\Ui\Livewire\Pages\PanelPage` and define their own slug.

## Related

- [Pages](/docs/ui/pages)
- [Resources](/docs/ui/resources)
