---
title: 'UI: Introduction'
nav_title: Introduction
description: 'Livewire admin panels on Core — panels, resources, and builders.'
section: packages
package: ui
order: 10
tags: [ui, introduction]
status: ready
---

Streams UI (`streams/ui`) builds Livewire admin panels on top of Streams Core. You register a **panel**, define **resource** classes for each stream, and configure **forms** and **tables** with PHP builders.

## Architecture

```text
Panel (UI::panel)
  └── Resources (PHP classes)
        ├── ListEntries  → Table builder
        ├── CreateEntry  → Form builder
        └── EditEntry    → Form builder
```

There are no `UI::form()` or `UI::table()` Blade helpers. Builders are PHP objects wired through Livewire pages.

## Minimal setup

```php
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Builders\Panels\Panel;

UI::panel(
    Panel::make('admin')
        ->default()
        ->path('admin')
        ->middleware(['web'])
        ->resources([PostResource::class])
);
```

Visit `/admin` after registering at least one resource.

## Related

- [Quick start](/docs/ui/quick-start)
- [Installation](/docs/ui/installation)
- [Panels](/docs/ui/panels)
