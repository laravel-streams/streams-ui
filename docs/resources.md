---
title: Resources
nav_title: Resources
description: 'PHP Resource subclasses — getPages(), table(), and form().'
section: packages
package: ui
order: 70
tags: [ui, resources]
status: ready
---

A **resource** connects a Core stream to admin CRUD pages. Subclass `Streams\Ui\Resources\Resource` and implement `getPages()`, `form()`, and `table()`.

## Basic resource

```php
class PostResource extends Resource
{
    protected static ?string $stream = 'posts';

    public static function getPages(): array
    {
        return [
            'index' => ListEntries::route('/'),
            'create' => CreateEntry::route('/create'),
            'edit' => EditEntry::route('/{entry}/edit'),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->components([/* ... */]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([/* ... */]);
    }
}
```

## Registration

```php
Panel::make('admin')->resources([PostResource::class]);
```

## Navigation

Override static properties or `getNavigationItems()`:

```php
protected static ?string $navigationGroup = 'Content';
protected static ?string $navigationLabel = 'Posts';
protected static ?string $navigationIcon = 'heroicon-o-document';
```

## URL helpers

```php
PostResource::getUrl('index');
PostResource::getUrl('edit', ['entry' => $id]);
```

## Does not exist

- `$panel->resource('posts', [...])` JSON registration
- Auto-generated forms from stream JSON alone (you implement `form()` and `table()`)

## Related

- [Pages](/docs/ui/pages)
- [Forms](/docs/ui/forms)
- [Tables](/docs/ui/tables)
