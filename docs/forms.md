---
title: Forms
category: basics
intro:
sort: 0
enabled: true
---

## Introduction

Form builders help you quickly build up form components.

### Configuration

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


# Configuration Examples

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
