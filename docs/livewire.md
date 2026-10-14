---
title: Livewire integration
nav_title: Livewire integration
description: InteractsWithTable, InteractsWithForms, and panel middleware.
section: packages
package: ui
order: 180
tags: [ui, livewire]
status: ready
---

Streams UI admin pages are Livewire components. Traits connect page state to form and table builders.

## Page traits

| Trait | Used by | Namespace |
|-------|---------|-----------|
| `InteractsWithTable` | `ListEntries` | `Streams\Ui\Livewire\Tables` |
| `InteractsWithForms` | `CreateEntry`, `EditEntry` | `Streams\Ui\Livewire\Forms` |
| `InteractsWithActions` | `Page` base | `Streams\Ui\Builders\Actions\Contracts` |

## ListEntries

```php
class ListEntries extends PanelPage
{
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return static::getResource()::table($table);
    }
}
```

## CreateEntry / EditEntry

```php
class CreateEntry extends PanelPage
{
    use InteractsWithForms;

    public function form(Form $form): Form
    {
        return static::getResource()::form($form);
    }
}
```

## Panel middleware

`SetUpPanel` runs on every panel request and calls `UI::bootCurrentPanel()` so builders resolve the active panel, routes, and navigation.

Livewire persistent middleware includes `SetUpPanel` for subsequent requests.

## Related

- [Architecture](/docs/ui/architecture)
- [Pages](/docs/ui/pages)
- [Routing](/docs/ui/routing)
