---
__created_at: 1612057092
__updated_at: 1612057092
title: Tables
category: components
intro: null
sort: 10
enabled: true
stage: outlining
---

1. [ ] **What** are tables?
1. [ ] How do you **use** tables?
2. [ ] How do you **build** tables?
3. [ ] How do you **secure** tables?
4. [ ] How do you **extend** tables?

- **Intro:** Introduce the idea in one sentence.
- **Explanation:** An elevator pitch that signals the reader to continue or not (keep looking for relevant page).
- **Sections/Features:** Separate sections/sub-sections (h2s/h3s) consistently. This will build the ToC.
- **Next Steps:** Next actions to take that are intentional versus simply additional reading.
- **Code Examples:** Code examples and snippets.
- **Insights:** Tips, post scriptum, creative links.
- **Additional Reading:** Link to related ideas/topics/guides/recipes.


## Introduction

Table builders help you quickly build up table components.

## Defining Tables

### Table Builders

You can instantiate a `TableBuilder` instance and interact with it directly.

```php
use Steams\Ui\Table\TableBuilder;

$builder = new TableBuilder($parameters = []);
```

### Stream Tables

Defining tables in your [stream configuration](../core/streams#defining-streams) makes it easy to display, filter, and customize tables based your domain information and entities.

Define stream tables using a `handle => parameters` format, where `handle` will be used to reference the table later and  `parameters` is an array of [parameters](#parameters) and [components](#components) configuration.

```json
// streams/example.json
{
    "ui": {
        "tables": {
            "default": {
                "actions": {
                    "delete": {}
                }
            }
        }
    }
}
```


### Parameters

The following parameters are available.

```json
{
    "stream": "contacts",
    "table": "default",
    "views": [],
    "filters": [],
    "columns": [],
    "buttons": [],
    "actions": [],
    "options": [],

    "builder": "App\\MyTableBuilder",
    "template": "ui::tables.table"
}
```

##### stream `string|Stream`

The stream to use for data and table configuration.

##### table `string`

The specific stream table configuration to use. The **default** configuration will be used otherwise.

#### builder `string`

Use the `builder` parameter to override the builder instance used to build the table component.

##### repository `string`

Use the `repository` parameter to override the repository instance used to fetch the entry. This parameter defaults to the stream configured repository if any.

```json
// streams/example.json
{
    "ui": {
        "tables": {
            "default": {
                "repository": "App\\MyTableRepository"
            }
        }
    }
}
```

##### options `array`

An array of table options.

### Configuration

Table configurations can also be @imports for more congiguration

```json
{
    "ui": {
        "table": {}
    }
}
```

Full configuration:

```json
{
    "ui": {
        "tables": {
            "default": {},
            "{handle}": {}
        }
    }
}
```

```php
use Steams\Ui\Table\TableBuilder;

$builder = new TableBuilder([
    'stream' => 'contacts',
    'columns' => [
        'name',
        'email',
    ],
]);
```

Configuration Examples

```json
{
    "table": [
        // Required Configuration
        "stream",   // The stream the entry belongs to
        
        // Optional Configuration
        "repository",   // The entry repository

        "builder",  // The table builder to use
        "table",    // The table component to use
        
        "assets",   // Assets to load
        
        "views",        // Table views configuration
        "filters",      // Table filters configuration
        "columns",      // Table columns configuration
        "actions",      // Table actions configuration
        "buttons",      // Table buttons configuration
        
        "options": [    // Component options array
            "sortable" // Enable sortable functionality
        ]
    ],
}
```


### Views
### Filters
### Columns
### Actions
### Buttons
