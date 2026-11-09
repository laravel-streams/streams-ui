---
title: Bulk actions
nav_title: Bulk actions
description: BulkAction, selection patterns, and grouped actions.
section: packages
package: ui
order: 160
tags: [ui, bulk, actions]
status: ready
---

Bulk actions operate on selected table rows. Register via `->bulkActions()` or `->groupedBulkActions()` on the table builder.

## BulkAction

```php
use Streams\Ui\Builders\Tables\BulkActions\BulkAction;

BulkAction::make('delete')
    ->label('Delete selected')
    ->action(function (Collection $records) {
        $records->each->delete();
    }),
```

Extends `Streams\Ui\Builders\Actions\Action`.

## Bulk action groups

```php
use Streams\Ui\Builders\Tables\BulkActions\BulkActionGroup;

->groupedBulkActions([
    BulkActionGroup::make('Export')->actions([
        BulkAction::make('csv')->action(/* ... */),
    ]),
])
```

## Built-in action

`DeleteSelectedEntries` is available for standard delete flows.

## Selection

Table Livewire state tracks selected entry keys. Bulk actions receive the selected record collection when invoked.

## Related

- [Tables](/docs/ui/tables)
- [Actions](/docs/ui/actions)
