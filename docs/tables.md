---
title: Overview
category: tables
sort: 0
---

- **Intro:** Introduce the idea in one sentance.
- **Explaination:** An elevator pitch that signals the reader to continue or not (keep looking for relavant page).
    - Table builders help you quickly build up table components.
- **Sections/Features:** Separate sections/sub-sections (h2s/h3s) consistently. This will build the ToC.
    - Basic Usage
    - Configuring Tables
- **Next Steps:** Next actions to take that are intentional versus simply additional reading.
- **Code Examples:** Code examples and snippets.
- **Insights:** Tips, post scriptum, creative links.
- **Additional Reading:** Link to related ideas/topics/guides/recipes.


---

All tables accept a standard array of attributes:
```php
$table = (new TableBuilder([
    'stream' => 'examples',
]))->build();
```

## Methods

All form builders provide a few methods of standard operation.

### Post

Handle post requests for form actions and filtering.

```php
$table = (new TableBuilder([
    'stream' => 'examples',
]))->build();

$table->post();
```
