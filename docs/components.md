---
title: Components
category: basics
sort: 0
enabled: true
stage: outlining
---


1. [ ] **What** is it?
1. [ ] How do you **use** it?
2. [ ] How do you **build** it?
3. [ ] How do you **extend** it?

- **Intro:** Introduce the idea in one sentence.
- **Explanation:** An elevator pitch that signals the reader to continue or not (keep looking for relevant page).
- **Sections/Features:** Separate sections/sub-sections (h2s/h3s) consistently. This will build the ToC.
- **Next Steps:** Next actions to take that are intentional versus simply additional reading.
- **Code Examples:** Code examples and snippets.
- **Insights:** Tips, post scriptum, creative links.
- **Additional Reading:** Link to related ideas/topics/guides/recipes.



## Introduction

UI Components are the foundation of the Streams UI system. They encapsulate the structural properties, rendering, and logical behavior of UI such as forms, tables, and buttons.

### Available Components

Below is a complete list of all first-party UI components:

@foreach (Streams::entries('docs_ui')->where('category', 'components')->orderBy('sort', 'ASC')->orderBy('name', 'ASC')->get() as $entry)
 - <a href="{{ $entry->id }}">{{ $entry->title }} ({{ $entry->decorate('stage') }})</a>
@endforeach


## Defining UI

There are a handful of ways to define UI components.
### Streams Components

Stream components are configured within the [stream definition](/docs/core/streams).

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

You can use the `ui` method to build the above configured UI component:

```php
$table = Streams::make('contacts')->ui('tables.example');
$form = Streams::make('contacts')->ui('forms.example');
```

### Generic Components

You can also instantiate UI components manually. In the below example, the provided `stream` parameter would be all that is required. The rest, you may customize to your liking.

> You may find that a component may require more fields if a `stream` parameter is not provided.

It is also important to note that components technically do not require a `stream` parameter.

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

### Blade Components

UI components are paired with corresponding [Laravel Blade components](https://laravel.com/docs/blade#components) which you may access manually in a similar manner.

```blade
@verbatim<x-table stream="contacts"/>@endverbatim
```

Each component documents its own configuration documentation.

### User Interface API

You can use the control panel API to access any configured UI component for a stream.

```php
GET|POST  /cp/ui/{stream}/{component}/{handle?}
```
