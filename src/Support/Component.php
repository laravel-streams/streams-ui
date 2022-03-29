<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Streams\Core\Stream\Stream;
use Streams\Ui\Support\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Contracts\Support\Jsonable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\Prototype;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Support\Traits\FiresCallbacks;

/**
 * @method Collection attributes
 */
class Component implements Arrayable, Jsonable
{
    use Prototype;
    use FiresCallbacks;

    use Macroable {
        Macroable::__call as private callMacroable;
    }

    public Stream $stream;

    public ?string $handle;
    public ?string $component;
    public ?string $template;

    #[Field([
        'config' => [
            'wrapper' => 'collection',
        ],
    ])]
    public array $classes = [];

    #[Field([
        'config' => [
            'wrapper' => 'collection',
        ],
    ])]
    public array $attributes;

    public function __construct(array $attributes = [])
    {
        $this->initializeComponentPrototype();
        $this->syncPublicPrototypeAttributes();

        $builder = $this->builder ?: Builder::class;

        (new $builder)
            ->passThrough($this)
            ->process([
                'component' => $this,
                'attributes' => collect($attributes),
            ]);
    }

    public function initializeComponentPrototype(array $attributes = [])
    {
        $this->loadPrototypeProperties([
            'attributes' => [
                'type' => 'array',
                'config' => [
                    'wrapper' => 'collection',
                ],
            ]
        ]);

        return $this->loadPrototypeAttributes(array_merge([
            'handle' => null,
            'template' => null,
            'component' => null,
            'data' => new Collection(),
        ], $attributes));
    }

    public function response()
    {
        if ($this->response) {
            return $this->response;
        }

        if (Request::method() == 'POST') {
            return $this->post();
        }

        if (View::shared('cp')) {
            return $this->cp();
        }

        return Response::view('ui::ui', ['content' => $this->render()]);
    }

    public function post()
    {
        return $this->response;
    }

    public function cp()
    {
        return Response::view('ui::cp', ['content' => $this->render()]);
    }

    public function class($extra = [])
    {
        if (!is_array($extra)) {
            $extra = explode(' ', $extra);
        }

        $classes = array_unique(
            array_merge(explode(' ', $this->class), (array) $this->classes, $extra)
        );

        return array_values(array_filter(array_unique($classes)));
    }

    public function attributes(array $attributes = [])
    {
        $class = Arr::pull($attributes, 'class');

        return collect(array_filter(array_replace_recursive([
            'class' => $this->class($class),
        ], $this->attributes, $attributes), function ($value) {
            return !is_null($value) && $value !== '';
        }));
    }

    public function htmlAttributes(array $attributes = [])
    {
        return Arr::htmlAttributes($this->attributes($attributes)->all());
    }

    public function render()
    {
        $payload = [
            Str::camel($this->component) => $this,
        ];

        return View::make($this->template, $payload)->render();
    }

    public function url(array $extra = [])
    {
        $type = Str::singular($this->component);
        $default = "ui/{$this->stream->handle}/{$type}/{$this->handle}";

        return URL::cp(Arr::get($this->options, 'url', $default), $extra);
    }

    public function request($key, $default = null)
    {
        return Request::get($this->prefix($key), $default);
    }

    public function prefix($target = null): string
    {
        return Arr::get($this->options, 'prefix') . $target;
    }

    public function setStreamAttribute($value)
    {
        if (is_string($value)) {
            $value = Streams::make($value);
        }

        $this->stream = $value;
    }

    public function toArray()
    {
        return Hydrator::dehydrate($this, ['observers', 'listeners']);
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function __toString()
    {
        return $this->template ? (string) $this->render() : '';
    }

    /**
     * Mapp methods to expanded values.
     *
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (static::hasMacro($method)) {
            return $this->callMacroable($method, $arguments);
        }

        $key = Str::snake($method);

        if ($this->hasPrototypeAttribute($key)) {
            return $this->decoratePrototypeAttribute($key);
        }

        throw new \BadMethodCallException(sprintf(
            'Method %s::%s does not exist.',
            static::class,
            $method
        ));
    }
}
