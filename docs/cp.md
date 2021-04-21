---
__created_at: 1612057264
__updated_at: 1612057264
title: Control Panel
category: core_concepts
sort: 0
enabled: true
stage: outlining
---

1. [ ] **What** is a control panel?
1. [ ] How do you **access** the control panel?
2. [ ] How do you **build** the control panel?
3. [ ] How do you **secure** the control panel?
4. [ ] How do you **customize** the control panel?


## Introduction

The control panel system wraps output with a highly configurable user interface layout.

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
    "title": "Users"
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
