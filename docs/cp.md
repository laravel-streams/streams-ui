---
title: Control Panel
link_title: Getting Started
category: control_panel
sort: 10
enabled: true
stage: outlining
---

## Introduction

The control panel is data driven and 

A sensible and generic control panel UI theme is available by default.

### Routing

You can use the the `routes/cp.php` file to define additional routes for the control panel. Routes defined there will be automatically prefixed and grouped.

Additionally, you can use the Route facade and **cp** method to define control panel routes.

```bash
Route::cp('custom/example/{entry}', 'Your\Controller@method');
```

- [Streams Core Routing](/docs/core/routing)

### Configuration

Before continueing please [enable the control panel](configuration#configuring-the-ui).

## Components

Multiple stream-enhanced components are used to assemble the control panel.

### Navigation

Navigation sections define the basic functional structure of your control panel.

#### Defining Navigation

```json
// streams/cp/navigation/users.json
{
    "title": "Users",
    "buttons": {
        "create": {}
    }
}
```

#### Stream Navigation

Navigation sections for streams can also be defined directly within the stream.

```json
// streams/users.json
{
    "ui": {
        "cp": {
            "section": {
                "title": "Users",
                "buttons": {
                    "create": {}
                }
            }
        }
    }
}
```

#### Available Properties

Name | Type | Default | Description
--|---|---|--
`text` | [string](/docs/core/fields/string) | `null` |  The link text.
`dropdown` | [object](#dropdowns) | `null` |  [Dropdown](dropdowns) items.


### Shortcuts

Shortcuts define globally displayed, highly configurable, actionable items.


#### Basic Example
#### Dropdowns

```json
// streams/cp/shortcuts/profile.json
{
    "sort_order": 99,
    "image": "/user/avatar",
    "dropdown": {
        "profile": {
            "text": "Visit Website",
            "attributes.href": "/",
            "target": "_blank"
        }
    }
}
```


### Layouts

Layouts define how to render the main content area of the control panel.


### Themes

Themes define globally accessible variables for the UI. Themes are defined by the `cp.themes` stream:


## Extending

By [publishing](configuration#publish-streams) the Streams UI package streams you can customize anything you need.
