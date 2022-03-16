<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Contracts\Support\Jsonable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\Prototype;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Support\Traits\FiresCallbacks;

/**
 * @typescript
 * @property string $handle
 * @property string $template
 * @property boolean $async
 * @property mixed $component
 * @property array $classes
 * @property array<string,mixed> $attributes
 * @property array<string,mixed> $options
 * @property \Illuminate\Support\Collection $data
 * @property \Illuminate\Http\Response $response
 * @property \Streams\Core\Stream\Stream $stream
 */
class Component implements Arrayable, Jsonable
{
    use Prototype;
    use FiresCallbacks;

    public $stream;

    public function __construct(array $attributes = [])
    {
        if (isset($attributes['stream']) && is_string($attributes['stream'])) {
            $attributes['stream'] = Streams::make($attributes['stream']);
        }

        if (isset($attributes['stream'])) {
            $this->stream = $attributes['stream'];
        }
        
        $callbackData = new Collection([
            'attributes' => $attributes,
        ]);

        $this->fire('initializing', [
            'callbackData' => $callbackData,
        ]);

        $this->syncOriginalPrototypeAttributes($callbackData->get('attributes'));

        //$this->setRawPrototypeAttributes($callbackData->get('attributes'));

        $this->initializeComponentPrototype($callbackData->get('attributes'));

        $this->fire('initialized', [
            'field' => $this,
        ]);
    }
    
    public function response()
    {
        if (Request::method() == 'POST') {
            $this->post();
        }

        if ($this->response) {
            return $this->response;
        }

        if (!$this->async && Request::ajax()) {
            return Response::view($this->render());
        }

        if ($this->async == true && Request::ajax()) {
            return Response::json($this);
        }

        if (Request::expectsJson()) {
            return Response::json($this);
        }

        if (View::shared('cp')) {
            return Response::view('ui::cp', ['content' => $this->render()]);
        }

        return Response::view('ui::ui', ['content' => $this->render()]);
    }


    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializeComponentPrototype(array $attributes)
    {
        return $this->setRawPrototypeAttributes(array_merge([
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
            array_merge(explode(' ', $this->class), (array) $this->classes, $extra)
        );

        return array_values(array_filter(array_unique($classes)));
    }

    public function attributes(array $attributes = [])
    {
        $class = Arr::pull($attributes, 'class');

        return array_filter(array_replace_recursive([
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
