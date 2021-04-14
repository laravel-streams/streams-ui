---
__created_at: 1612056481
__updated_at: 1612056481
title: Builders
category: core_concepts
sort: 10
stage: outlining
enabled: false
---
## Introduction

Builders are factory-like classes that build **components** from basic array **parameters**.

```php
use Steams\Ui\Support\Builder;

$builder = new Builder($parameters = []);
```

### Building Components

Components are the underlying PHP clases doing the work when leveraging the features of the UI package. **Builders build components.**

### Builder Responses

Builders can provide a shortcut to generating built component responses that are contextually accurate.

```php
$builder->response();
// or
$builder->render();
$builder->post();
// etc
```

### Configuring Builders

Builder **parameters** can be passed directly to the builder instance.

```php
use Steams\Ui\Support\Builder;

$builder = new Builder($parameters = []);
```

#### Stream Components

[Stream configuration](../core/streams#defining-streams) can be used to define stream-related UI components like tables and forms. These are typically configured by **handle**.

```json
// streams/example.json
{
    ...
    "ui": {
        "forms": {
            "default": {
                ...
            }
        }
    }
}
```

The above default form can be accessed from the stream object.

```php
use Steams\Core\Support\Facades\Streams;

$form = Streams::make('entries')->form($table = 'default', $extra = []);
```

#### Default Configuration

By default, no configuration is needed at all for many components, though, as you build specificity into your application you can leverage our vast configuration API to fine-tune multiple complex component behaviors with ease that can be called upon in an instant.

```php
return Streams::make('contacts')->form()->response();
return Streams::make('contacts')->form()->response();
return Streams::make('contacts')->table()->response();
```
