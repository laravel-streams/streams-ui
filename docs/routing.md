---
__created_at: 1612057264
__updated_at: 1612057264
title: Routing
category: control_panel
sort: 0
enabled: true
stage: outlining
---

- **Intro:** Introduce the idea in one sentence.
- **Explanation:** An elevator pitch that signals the reader to continue or not (keep looking for relevant page).
- **Sections/Features:** Separate sections/sub-sections (h2s/h3s) consistently. This will build the ToC.
- **Next Steps:** Next actions to take that are intentional versus simply additional reading.
- **Code Examples:** Code examples and snippets.
- **Insights:** Tips, post scriptum, creative links.
- **Additional Reading:** Link to related ideas/topics/guides/recipes.



## Introduction

Streams UI provides an interface for building data-driven, highly configurable control panels that can be integrated with any admin panel or UI kit.

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
