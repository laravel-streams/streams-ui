---
title: Filters
nav_title: Filters
description: Text, Select, Search, Toggle, and Criteria table filters.
section: packages
package: ui
order: 150
tags: [ui, filters]
status: ready
---

Filters narrow table results. Register on the table builder via `->filters([...])`.

## Filter classes

| Class | Purpose |
|-------|---------|
| `SearchFilter` | Global search across searchable columns |
| `TextFilter` | Filter single field by text |
| `SelectFilter` | Filter by select options |
| `ToggleFilter` | Boolean filter |
| `CriteriaFilter` | Custom criteria closure |

Namespace: `Streams\Ui\Builders\Tables\Filters`

## Example

```php
->filters([
    SearchFilter::make('search'),
    SelectFilter::make('status')
        ->options(['draft' => 'Draft', 'published' => 'Published']),
    ToggleFilter::make('featured'),
])
```

## Criteria filter

For advanced queries, use `CriteriaFilter` to modify the Core criteria instance directly.

## Related

- [Tables](/docs/ui/tables)
- [Core criteria](/docs/core/criteria)
