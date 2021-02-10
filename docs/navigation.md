---
title: Navigation
category: control_panel
sort: 10
enabled: true
---

## Introduction

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
