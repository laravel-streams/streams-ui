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


All forms accept a standard array of attributes:
```php
$form = (new FormBuilder([
    'stream' => 'examples',
    'inputs' => [
        'field_slug' => 'input_type',
    ],
]))->build();
```

## Methods

All form builders provide a few methods of standard operation.

### Post

Load form values from post submission data.

```php
$form = (new FormBuilder([
    'stream' => 'examples',
]))->build();

$form->post();
```

### Validate

Validate form posted submissions.

```php
$form = (new FormBuilder([
    'stream' => 'examples',
]))->build();

$form->validate();
```

### Save

```php
$form = (new FormBuilder([
    'stream' => 'examples',
]))->build();

$form->save();
```
