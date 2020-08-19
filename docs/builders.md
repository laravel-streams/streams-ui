---
title: Builders
category: core_concepts
intro: 
sort: 10
---

- **Intro:** Introduce the idea in one sentance.
    - Builders are classes that help you quickly build up UI component objects.
- **Explaination:** An elevator pitch that signals the reader to continue or not (keep looking for relavant page).
- **Sections/Features:** Separate sections/sub-sections (h2s/h3s) consistently. This will build the ToC.
    - Attributes
- **Next Steps:** Next actions to take that are intentional versus simply additional reading.
- **Code Examples:** Code examples and snippets.
- **Insights:** Tips, post scriptum, creative links.
- **Additional Reading:** Link to related ideas/topics/guides/recipes.

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
