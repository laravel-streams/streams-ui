---
title: Components
category: basics
intro:
sort: 0
enabled: true
---

Components encapsulate the structural properties, rendering, and logical behavior of UI objects which they represent such as forms, tables, and buttons.

## Configuring Components

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
