---
title: Builders
category: core_concepts
intro: 
sort: 10
---

- **Intro:** Introduce the idea in one sentance.
    - Builders are classes that help you quickly build up UI component objects.
- **Explaination:** An elevator pitch that signals the reader to continue or not (keep looking for relavant page).
    - Build Components
- **Sections/Features:** Separate sections/sub-sections (h2s/h3s) consistently. This will build the ToC.
    - Configuration
        - stream
        - 
    - Basic Usage
        - Rendering Components
    - Component Responses
        - JSON Responses
- **Next Steps:** Next actions to take that are intentional versus simply additional reading.
    - Build a Table
    - Build a Form
- **Code Examples:** Code examples and snippets.
- **Insights:** Tips, post scriptum, creative links.
- **Additional Reading:** Link to related ideas/topics/guides/recipes.
    - Tables
    - Forms
    - Buttons
    - Icons

All builders accept an array of attributes and return an instance via the `build` method:
```php
$instance = (new Builder([
    'stream' => 'examples',
]))->build();
```

## Output

All builders provide a few methods of standard output.-m-0

### Views

```php
$instance = (new Builder([
    'stream' => 'examples',
]))->build();

$instance->render();
```

### JSON

```php
$instance = (new Builder([
    'stream' => 'examples',
]))->build();

$instance->toJson();
```

### Array

```php
$instance = (new Builder([
    'stream' => 'examples',
]))->build();

$instance->toArray();
```

### Response

```php
$instance = (new Builder([
    'stream' => 'examples',
]))->build();

$instance->response();
```
