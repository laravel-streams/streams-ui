---
title: Overview
category: forms
intro:
sort: 0
---

- **Intro:** Introduce the idea in one sentance.
    - Form builders help you quickly build up form components.
- **Explaination:** An elevator pitch that signals the reader to continue or not (keep looking for relavant page).
- **Sections/Features:** Separate sections/sub-sections (h2s/h3s) consistently. This will build the ToC.
- **Next Steps:** Next actions to take that are intentional versus simply additional reading.
- **Code Examples:** Code examples and snippets.
- **Insights:** Tips, post scriptum, creative links.
- **Additional Reading:** Link to related ideas/topics/guides/recipes.


Form configurations can also be @imports for more congiguration

Minimal configuration:

```json
{
    "ui": {
        "form": {},
        "table": {}
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
        },
        "tables": {
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
