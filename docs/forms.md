---
__created_at: 1612057067
__updated_at: 1612057067
title: Forms
category: components
intro: null
sort: 20
enabled: true
stage: outlining
---

1. [ ] **What** are forms?
1. [ ] How do you **use** forms?
2. [ ] How do you **build** forms?
3. [ ] How do you **secure** forms?
4. [ ] How do you **extend** forms?


- **Intro:** Introduce the idea in one sentence.
- **Explanation:** An elevator pitch that signals the reader to continue or not (keep looking for relevant page).
- **Sections/Features:** Separate sections/sub-sections (h2s/h3s) consistently. This will build the ToC.
- **Next Steps:** Next actions to take that are intentional versus simply additional reading.
- **Code Examples:** Code examples and snippets.
- **Insights:** Tips, post scriptum, creative links.
- **Additional Reading:** Link to related ideas/topics/guides/recipes.



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
