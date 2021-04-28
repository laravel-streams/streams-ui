---
title: Components
link_title: Getting Started
category: components
intro:
sort: 0
enabled: true
---

## Introduction

Components are the foundation of the Streams UI system. They encapsulate the structural properties, rendering, and logical behavior of UI objects such as forms, tables, and buttons.

### Available Components

The components available out of the box are:

- [Tables](tables)
- [Forms](forms)

Some components are meant to be used within others:

- [Buttons](buttons)
- [Dropdowns](dropdowns)

### Configuring Components

Components are configured within the [stream definition](/docs/core/streams).

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

## Accessing UI

You can use the `ui` method to build any configured UI component for a stream.

```php
$table = Streams::make('contacts')->ui('tables.example');
$form = Streams::make('contacts')->ui('forms.example');
```

### Control Panel API

You can use the control panel API to access any configured UI component for a stream.

```php
GET|POST  /cp/ui/{stream}/{component}/{handle?}
```
