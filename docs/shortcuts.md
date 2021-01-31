---
title: Shortcuts
category: control_panel
sort: 20
enabled: true
---

## Introduction

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
