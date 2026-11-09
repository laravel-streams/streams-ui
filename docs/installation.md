---
title: 'UI: Installation'
nav_title: Installation
description: 'Composer, UI::panel(Panel::make()), publish tags, and middleware.'
section: packages
package: ui
order: 20
tags: [ui, installation]
status: ready
---

Install UI alongside Core in your Laravel application.

## Require the package

```bash
composer require streams/core:2.0.x-dev streams/ui:1.0.x-dev
```

UI requires `streams/core ^2.0` and Livewire `^3.0`. Neither Core 2.0 nor UI 1.0 has a stable tag yet, so require both development branches explicitly (or set `"minimum-stability": "dev"` with `"prefer-stable": true`). See [Versions and support](/docs/versions).

## Register a panel

In `AppServiceProvider::boot()`:

```php
use Streams\Ui\Support\Facades\UI;
use Streams\Ui\Builders\Panels\Panel;

UI::panel(
    Panel::make('admin')
        ->default()
        ->path('admin')
        ->brandName('My App')
        ->middleware(['web'])
);
```

## Publish tags

From `UiServiceProvider`:

```bash
php artisan vendor:publish --tag=config --provider="Streams\Ui\UiServiceProvider"
php artisan vendor:publish --tag=laravel-streams --provider="Streams\Ui\UiServiceProvider"
php artisan vendor:publish --tag=ui --provider="Streams\Ui\UiServiceProvider"
```

| Tag | Output |
|-----|--------|
| `config` | `config/streams/ui.php` |
| `laravel-streams` | `streams/` scaffold |
| `ui` | `resources/views/vendor/ui/` view overrides |

Package views use the `ui::` namespace. Assets register via `Assets::addPath('ui', ...)`.

## Middleware

UI registers middleware alias `panel` → `Streams\Ui\Http\Middleware\SetUpPanel`. Panel routes apply `panel:{id}` automatically.

## Related

- [Quick start](/docs/ui/quick-start)
- [Panels](/docs/ui/panels)
