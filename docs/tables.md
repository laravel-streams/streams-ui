---
title: Tables
intro: Table builders help you quickly build up table components.
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

Load form values from post submission data.

```php
$table = (new TableBuilder([
    'stream' => 'examples',
]))->build();

$table->post();
```

### Validate

Validate form posted submissions.

```php
$table = (new TableBuilder([
    'stream' => 'examples',
]))->build();

$table->validate();
```

### Save

```php
$table = (new TableBuilder([
    'stream' => 'examples',
]))->build();

$table->save();
```
