---
__created_at: 1612057264
__updated_at: 1612057264
title: Control Panel
category: components
sort: 0
enabled: true
stage: outlining
---

## Introduction

The control panel is an easily configurable administrative tool.

### Configuration

*Control panel theme configuration is currently in development.*

### Responses

The control panel will **automatically** wrap other builder view responses with the `ui::cp` layout *when responses are generated within the control panel URI prefix*.

Both examples are wrapped by the `ui::cp` view layout.

```php
// GET: {cp_prefix}/{example}
use Streams\Core\Support\Facades\Streams;

return Streams::make('example')->table()->response();
```

```php
// GET: random/{example}
use Streams\Core\Support\Facades\Streams;

return Streams::make('example')->table([
    'options.cp_enabled' => true,
])->response();
```


## Navigation

Navigation sections are the primary building blocks of the control panel.

## Creating Navigation

### Manually

You can manually create a JSON file with the below [attributes](#attributes) in the navigation directory.

### Using Streams CLI

You can create a new `cp.navigation` entry using [streams-cli](../cli/introduction).

```bash
php artisan entries:create cp.navigation
```

## Component

### Attributes

```json
// // streams/cp/navigation/{id}.json
{
    "title": "Documentation",
    "stream": "docs",
    "parent": null,
    "buttons": {},
    "route": {}
}
```

#### id `slug`

The unique handle of the shortcut.

#### title `string`

A (translatable) string for display purposes.

#### stream `string`

The contextual stream for this navigation section. Forms will create entries for this stream and tables will display entries for this stream, for example. The **id** will be assumed the same as the stream handle if not configured.

#### parent `string`

The **id** of the parent navigation item. Two levels of nesting are supported out of the box.

#### buttons `array`

An associated array of [buttons](buttons).

#### route `array`

An associated array of additional [route information](../core/routing).



## Shortcuts

Shortcuts are the basic building blocks of the control panel **topbar**.

## Creating Shortcuts

### Manually

You can manually create a JSON file with the below [attributes](#attributes) in the shortcuts directory.

### Using Streams CLI

You can create a new `cp.shortcuts` entry using [streams-cli](../cli/introduction).

```bash
php artisan entries:create cp.shortcuts
```

## Component

### Attributes

```json
// // streams/cp/shortcuts/{id}.json
{
    "image": "/auth/avatar",
    "icon": "far-user-circle",
    "svg": "<svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">
  <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z\" />
</svg>",
    "dropdown": {
        "profile": {
            "text": "Visit Website",
            "href": "/",
            "target": "_blank"
        },
        "logout": {
            "text": "Logout",
            "href": "/logout",
            "target": "_blank"
        }
    }
}
```

#### id `slug`

The unique handle of the shortcut.

#### image `string`

Any valid [image source](../core/images#image-sources).

#### icon `string`

Any valid [icon identifier](icons).

#### svg `string`

An SVG content string.

#### dropdown `array`

An associative array of dropdown menu items indexed by **handle**.
