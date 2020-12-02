---
title: Forms
category: core_concepts
intro:
sort: 0
enabled: true
---

## Introduction

Form builders help you quickly build up form components.

## Defining Forms

### Form Builders

You can instantiate a `FormBuilder` instance and interact with it directly.

```php
use Steams\Ui\Form\FormBuilder;

$builder = new FormBuilder($parameters = []);
```

### Stream Forms

Defining forms in your [stream configuration](../core/streams#defining-streams) makes it easy to display, validate, and customize forms based your domain information and entities.

Define stream forms using a `handle => parameters` format, where `handle` will be used to reference the form later and  `parameters` is an array of [parameters](#parameters) and [components](#components) configuration.

```json
// streams/example.json
{
    "ui": {
        "forms": {
            "default": {
                "options.redirect": "thank-you"
            }
        }
    }
}
```


## Parameters

The following parameters are available though may not be required.

### Stream

Use the `stream` parameter to specify the stream to use for entry data. If the form was defined on a stream this is optional.

```php
use Steams\Ui\Form\FormBuilder;

$builder = new FormBuilder([
    'stream' => 'contacts',
]);
```

### Entry

Use the `entry` parameter to specify the entry `id` or instance to use for the form. If none is specified, default behavior will create a new entry upon submission.

```php
use Steams\Ui\Form\FormBuilder;

$builder = new FormBuilder([
    'stream' => 'contacts',
    'entry' => Request::get('id'),
]);
```

### Builder

Use the `builder` parameter to override the builder instance used to build the form component.

```json
// streams/example.json
{
    "ui": {
        "forms": {
            "default": {
                "builder": "App\\MyFormRepository"
            }
        }
    }
}
```

### Repository

Use the `repository` parameter to override the repository instance used to fetch the entry. This parameter defaults to the stream configured repository if any.

```json
// streams/example.json
{
    "ui": {
        "forms": {
            "default": {
                "repository": "App\\MyFormRepository"
            }
        }
    }
}
```

### Options

Options listed here:

## Components

Form configurations can also be @imports for more congiguration

```json
{
    "ui": {
        "form": {}
    }
}
```

Full configuration:

```json
{
    "ui": {
        "forms": {
            "default": {},
            "{handle}": {}
        }
    }
}
```

```php
$form = (new FormBuilder([
    'stream' => 'examples',
    'inputs' => [
        'field_slug' => 'input_type',
    ],
]))->build();
```

Configuration Examples

```json
{
    "form": [
        // Required Configuration
        "stream",   // The stream the entry belongs to
        "entry",    // The entry to edit or null to create
        
        // Optional Configuration
        "repository",   // The entry repository

        "builder",  // The form builder to use
        "form",     // The form component to use
        
        "assets",   // Assets to load
        
        "fields",   // Form fields configuration
        "rules",    // Form rules configuration
        "actions",  // Form actions configuration
        "buttons",  // Form buttons configuration
        "sections", // Form sections configuration
        
        "options": [      // Component options array
            ""
        ]
    ],
}
```

### Fields
### Rules
### Actions
### Buttons
### Sections
