---
title: Actions
nav_title: Actions
description: Action, modals, redirects, and table header/row action groups.
section: packages
package: ui
order: 170
tags: [ui, actions]
status: ready
---

Actions are buttons that run closures, open modals, or redirect. Base class: `Streams\Ui\Builders\Actions\Action`.

## Basic action

```php
use Streams\Ui\Builders\Actions\Action;

Action::make('publish')
    ->label('Publish')
    ->icon('heroicon-o-check')
    ->action(function ($entry) {
        $entry->published = true;
        $entry->save();
    });
```

## Table actions

Register on the table builder:

```php
->actions([
    Action::make('edit')->url(fn ($entry) => PostResource::getUrl('edit', ['entry' => $entry])),
])
->headerActions([
    Action::make('create')->url(fn () => PostResource::getUrl('create')),
])
```

## Modals and forms

Actions support modal forms via `->form([...])` and redirect via `->redirect()` concerns on `MountableAction`.

## Action groups

`ActionGroup` and table-specific action classes organize related actions in dropdown menus.

## Related

- [Bulk actions](/docs/ui/bulk-actions)
- [Tables](/docs/ui/tables)
- [Livewire integration](/docs/ui/livewire)
