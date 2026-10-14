---
title: Quick start
nav_title: Quick start
description: Register a panel, one Resource class, and visit /admin.
section: packages
package: ui
order: 30
tags: [ui, quick, start]
status: ready
---

This walkthrough registers an admin panel with one resource backed by a Core stream.

## 1. Define a stream

`streams/posts.json`:

```json
{
    "id": "posts",
    "fields": [
        { "handle": "title", "type": "string", "required": true },
        { "handle": "body", "type": "string" }
    ]
}
```

## 2. Create a resource class

`app/Ui/Posts/PostResource.php`:

```php
namespace App\Ui\Posts;

use Streams\Ui\Resources\Resource;
use Streams\Ui\Builders\Forms\Form;
use Streams\Ui\Builders\Tables\Table;
use Streams\Ui\Builders\Forms\Layouts\Field;
use Streams\Ui\Builders\Inputs\TextInput;
use Streams\Ui\Builders\Inputs\TextareaInput;
use Streams\Ui\Builders\Tables\Columns\TextColumn;
use Streams\Ui\Livewire\Pages\ListEntries;
use Streams\Ui\Livewire\Pages\CreateEntry;
use Streams\Ui\Livewire\Pages\EditEntry;

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
        return $form->components([
            Field::make('title')->input(TextInput::make('title')),
            Field::make('body')->input(TextareaInput::make('body')),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('title'),
        ]);
    }
}
```

## 3. Register the panel

```php
UI::panel(
    Panel::make('admin')
        ->default()
        ->path('admin')
        ->middleware(['web'])
        ->resources([PostResource::class])
);
```

## 4. Visit the panel

Open `/admin/posts` (resource slug derived from class name).

## Related

- [Resources](/docs/ui/resources)
- [Forms](/docs/ui/forms)
- [Tables](/docs/ui/tables)
