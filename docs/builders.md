---
__created_at: 1612056481
__updated_at: 1612056481
title: Builders
category: core_concepts
sort: 10
stage: outlining
enabled: true
---
## Introduction

Builders are factory-like classes that build **components** from basic array **parameters**.

```php
use Steams\Ui\Table\TableBuilder;

$builder = new TableBuilder($parameters = []);
```

The UI package provides builders for major components like **forms** and **tables**.

### Builder Lifecycle

Builders go through a short lifecycle and can handle a variety of request types as well as return a variety of response types.

### Building Components

```php
$component = $builder->build();

$component->post();
$component->render();
$component->toJson();
```

#### Nested Components

Builders can define and build nested collections of components.

```php
$table = $builder->build([
    'columns' => [
        'id' => [
            'value' => 'entry.id',
        ],
    ]
]);

$table->rows->each(function() {
    echo $row->columns->first()->value;
});
```


## Defining Builders

Typically, **forms** and **tables** parameters are stored in stream configuration. **Navigation** and **shortcuts** for the control panel, however, are powered by streams and flat-file JSON data.

The available **parameters** are the same.

## Basic Usage

Builders can be configured and used, directly in your PHP classes. Here is an example of rendering a [TableBuilder](/tables) as a controller response.

```php
namespace App\Http\Controllers;

use Streams\Ui\Table\TableBuilder;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index($stream)
    {
        $builder = new TableBuilder([
            'stream' => $stream,
            'columns' => [
                'id',
                'title',
            ],
        ]);

        return $builder->response();
    }
}
```

### Streams Builders

You can also call **table** and **form** builders from stream instances.

```php
namespace App\Http\Controllers;

use Streams\Core\Support\Facades\Streams;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index($stream)
    {
        return Streams::make($stream)
            ->table([
                'columns' => [
                    'id'
                ]
            ])
            ->render();
    }
}
```

### JSON Responses

Components can provide JSON representations of themselves recursively using `toJson()`.

```php
namespace App\Http\Controllers;

use Streams\Ui\Table\TableBuilder;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index($stream)
    {
        $builder = new TableBuilder([
            'stream' => $stream,
            'columns' => [
                'id',
                'title',
            ],
        ]);

        return $builder->toJson();
    }
}
```
