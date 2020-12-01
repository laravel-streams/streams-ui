---
title: Tables
category: basics
sort: 0
enabled: true
---

## Introduction

Table builders help you quickly build up form components.

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
$table = (new TableBuilder([
    'stream' => 'examples',
    'columns' => [
        'name',
        'email',
    ],
]))->build();
```

# Configuration Examples

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
