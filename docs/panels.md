---
title: Panels
nav_title: Panels
description: Path, middleware, default panel, branding, and SetUpPanel.
section: packages
package: ui
order: 50
tags: [ui, panels]
status: ready
---

A **panel** is an admin area with its own path, middleware, navigation, resources, and pages.

## Register a panel

```php
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Builders\Panels\Panel;

UI::panel(
    Panel::make('admin')
        ->default()
        ->path('admin')
        ->brandName('Acme')
        ->middleware(['web', 'auth'])
        ->resources([PostResource::class])
        ->pages([DashboardPage::class])
);
```

## Panel options

| Method | Purpose |
|--------|---------|
| `path()` | URL prefix (`/admin`) |
| `domain()` / `domains()` | Restrict to hostnames |
| `default()` | Mark as default panel for URL generation |
| `middleware()` | Additional middleware (always includes `panel:{id}`) |
| `brandName()`, logo traits | Branding |
| `homeUrl()` | Panel home link |
| `routes(Closure)` | Custom route registration |

## SetUpPanel middleware

Alias `panel` maps to `Streams\Ui\Http\Middleware\SetUpPanel`. It boots the current panel before Livewire handles the request.

## Related

- [Installation](/docs/ui/installation)
- [Theming](/docs/ui/theming)
- [Routing](/docs/ui/routing)
- [Navigation](/docs/ui/navigation)
