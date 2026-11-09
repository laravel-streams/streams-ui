---
title: Columns
nav_title: Columns
description: Text, Link, Image, Icon, Toggle, and other table columns.
section: packages
package: ui
order: 140
tags: [ui, columns]
status: ready
---

Columns display entry values in resource tables. All extend `Streams\Ui\Builders\Tables\Columns\Column`.

## Available columns

| Class | Purpose |
|-------|---------|
| `TextColumn` | Plain text |
| `LinkColumn` | Clickable link |
| `SelectColumn` | Select display |
| `ToggleColumn` | Inline toggle |
| `IconColumn` | Icon by value |
| `ImageColumn` | Thumbnail image |
| `ColorColumn` | Color swatch |
| `BadgeColumn` | Badge label |
| `ViewColumn` | Custom Blade view |

## Example

```php
TextColumn::make('title')
    ->label('Title')
    ->sortable()
    ->searchable(),

LinkColumn::make('title')
    ->url(fn ($entry) => PostResource::getUrl('edit', ['entry' => $entry])),

ToggleColumn::make('published'),
```

## Related

- [Tables](/docs/ui/tables)
- [Filters](/docs/ui/filters)
