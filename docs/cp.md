---
__created_at: 1612057264
__updated_at: 1612057264
title: Control Panel
category: basics
sort: 0
enabled: true
stage: outlining
---
## Introduction

The control panel system provides a simple, highly configurable interface for defining the control panel experience your project needs.

### Configuration

All streams configuration is stored in `/streams/cp/{component}/*`.

## Components

### Navigation

The filename of the navigation entry serves as the **id** and is referenced in the control panel URI like `/{cp_prefix}/{id}/*`.

```json
// // streams/cp/navigation/docs.json
{
    "title": "Documentation",
    "stream": "docs",
    "buttons": {
        "create": {},
        "view": {
            "href": "/docs/{entry.id}",
            "target": "_blank"
        }
    },
    "route": {}
}
```

#### title `string`

A (translatable) string for display purposes.

#### stream `string`

The contextual stream for this navigation section. Forms will create entries for this stream and tables will display entries for this stream, for example. The **id** will be assumed the same as the stream handle if not configured.

#### parent `string`

The **id** of the parent navigation item. Two levels of nesting are supported out of the box.

#### policy `string`

The **id** of a policy to run for accessing this navigation section.

## Shortcuts

```json
// // streams/cp/shortcuts/user.json
{
    "icon": null,
    "image": "https://source.unsplash.com/hoS3dzgpHzw/256x256",
    "svg": null,
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

#### image `string`

Any valid [image source](../core/images#image-sources).

#### icon `string`

Any valid [icon identifier](icons).

#### svg `string`

An SVG content string.

#### dropdown `array`

An associative array of dropdown menu items indexed by **handle**.
