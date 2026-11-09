---
title: Tables
nav_title: Tables
description: 'Table::make($livewire), query, columns, filters, and pagination.'
section: packages
package: ui
order: 130
tags: [ui, tables]
status: ready
---

Tables list stream entries in admin resources via `Streams\Ui\Builders\Tables\Table`.

## Basic table

```php
public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('title')->sortable(),
            TextColumn::make('created_at'),
        ])
        ->filters([
            SearchFilter::make('search'),
        ])
        ->defaultSort('title');
}
```

## Factory

```php
Table::make($livewire);   // used by ListEntries
Table::for($livewire);    // alias
```

`ListEntries` passes the Livewire component automatically:

```php
public function table(Table $table): Table
{
    return static::getResource()::table($table);
}
```

## Query

Table uses `HasQuery` and `HasStream` concerns to build a Core criteria instance from the resource's stream.

## Pagination, sorting, filters

Built-in concerns handle pagination, column sorting, and filter state. See [Columns](/docs/ui/columns), [Filters](/docs/ui/filters), and [Bulk actions](/docs/ui/bulk-actions).

## Does not exist

- `UI::table()` Blade helper
- Stream JSON `ui.tables` auto-wiring without PHP resource classes

## Related

- [Columns](/docs/ui/columns)
- [Filters](/docs/ui/filters)
- [Resources](/docs/ui/resources)
