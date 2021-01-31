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

## Navigation

#### Navigation Stream

```php
Streams::register([
    'handle' => 'cp.navigation',
    'source' => [
        'path' => 'streams/cp/navigation',
        'format' => 'json',
    ],
    'config' => [
        'prototype' => 'Streams\\Ui\\ControlPanel\\Component\\Navigation\\Section',
    ],
    'fields' => [
        'title' => 'string',
        'parent' => [
            'type' => 'relationship',
            'related' => 'cp.navigation',
        ],
    ],
]);
```

#### Example Navigation Section

```json
// // streams/cp/navigation/docs.json
{
    "title": "Documentation",
    "stream": "docs",
    "buttons": {
        "create": {},
        "view": {
            "href": "/docs/core/introduction",
            "target": "_blank"
        }
    }
}
```

## Shortcuts

#### Shortcuts Stream

```php
Streams::register([
    'handle' => 'cp.shortcuts',
    'source' => [
        'path' => 'streams/cp/shortcuts',
        'format' => 'json',
    ],
    'config' => [
        'prototype' => 'Streams\\Ui\\ControlPanel\\Component\\Shortcut\\Shortcut',
    ],
    'fields' => [
        'title' => 'string',
        'icon' => 'string',
        'svg' => 'string',
    ],
]);
```

#### Example Navigation Section

```json
// // streams/cp/shortcuts/user.json
{
    "image": "https://source.unsplash.com/hoS3dzgpHzw/256x256",
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
