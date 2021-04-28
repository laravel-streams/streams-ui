<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Support\Jsonable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\Prototype;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Support\Traits\FiresCallbacks;

/**
 *
 * @property string handle
 * @property string template
 * @property mixed component
 * @property array classes
 * @property array attributes
 * @property Collection data
 * @property \Streams\Core\Stream\Stream stream
 */
class Component implements Arrayable, Jsonable
{
    use FiresCallbacks;

    use Prototype {
        Prototype::initializePrototypeAttributes as private initializePrototype;
    }

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $callbackData = new Collection([
            'attributes' => $attributes,
        ]);

        $this->fire('initializing', [
            'callbackData' => $callbackData,
        ]);

        $this->initializePrototypeAttributes($callbackData->get('attributes'));

        $this->fire('initialized', [
            $this->component => $this,
        ]);
    }

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
    {
        return $this->initializePrototype(array_merge([
            'handle' => null,
            'template' => null,
            'component' => null,
            'classes' => [],
            'attributes' => [],
            'data' => new Collection(),
        ], $attributes));
    }

    public function class($extra = [])
    {
        if (!is_array($extra)) {
            $extra = explode(' ', $extra);
        }

        $classes = array_unique(
            array_merge(explode(' ', $this->class), $this->classes, $extra)
        );

        return trim(implode(' ', $classes));
    }

    public function attributes(array $attributes = [])
    {
        $class = Arr::pull($attributes, 'class');

        return array_filter(array_merge([
            'class' => $this->class($class),
        ], (array) $this->getPrototypeAttribute('attributes', []), $attributes), function ($value) {
            return !is_null($value) && $value !== '';
        });
    }

    public function htmlAttributes(array $attributes = [])
    {
        return Arr::htmlAttributes($this->attributes($attributes));
    }

    public function render()
    {
        $payload = [
            Str::camel($this->component) => $this,
        ];

        return View::make($this->template, $payload);
    }

    public function url(array $extra = [])
    {
        if (!$stream = $this->stream) {
            return;
        }

        $type = Str::singular($this->component);
        $default = "ui/{$stream->handle}/{$type}/{$this->handle}";

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
            return $this->expandPrototypeAttribute($key);
        }

        throw new \BadMethodCallException(sprintf(
            'Method %s::%s does not exist.',
            static::class,
            $method
        ));
    }
}
