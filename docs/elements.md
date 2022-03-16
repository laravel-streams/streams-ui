---
title: Elements
category: basics
intro:
sort: 0
enabled: true
stage: outlining
---

## Introduction

UI Elements are the foundation of the Streams UI system. They encapsulate the structural properties, rendering, and logical behavior of UI such as forms, tables, and buttons.

### Available Elements

Below is a complete list of all first-party UI elements:

@foreach (Streams::entries('docs_ui')->where('category', 'elements')->orderBy('sort', 'ASC')->orderBy('name', 'ASC')->get() as $entry)
 - <a href="{{ $entry->id }}">{{ $entry->title }} ({{ $entry->decorate('stage') }})</a>
@endforeach


## Defining UI

There are a handful of ways to define UI elements.
### Streams Elements

Stream elements are configured within the [stream definition](/docs/core/streams).

```json
// streams/contacts.json
{
    // ...
    "ui": {
        "tables": {
            "example": {
                // ...
            }
        },
        "forms": {
            "example": {
                // ...
            }
        }
    }
}
```

You can use the `ui` method to build the above configured UI element:

```php
$table = Streams::make('contacts')->ui('tables.example');
$form = Streams::make('contacts')->ui('forms.example');
```

### Generic Elements

You can also instantiate UI elements manually. In the below example, the provided `stream` parameter would be all that is required. The rest, you may customize to your liking.

> You may find that a element may require more fields if a `stream` parameter is not provided.

It is also important to note that elements technically do not require a `stream` parameter.

```php
use Streams\Ui\Table\Table;

$table = new Table([
    'stream' => $stream,
    'columns' => [
        // ...
    ],
]);
```


## Basic Usage

### Blade Elements

UI elements are paired with corresponding [Laravel Blade elements](https://laravel.com/docs/blade#elements) which you may access manually in a similar manner.

```blade
@verbatim<x-streams-ui-table stream="contacts"/>@endverbatim
```

Each element documents its own configuration documentation.

### User Interface API

You can use the control panel API to access any configured UI element for a stream.

```php
GET|POST  /cp/ui/{stream}/{element}/{handle?}
```
