<?php

namespace Streams\Ui\Support;

use Exception;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\Fluency;
use Illuminate\Contracts\Support\Jsonable;
use Streams\Core\Support\Traits\Prototype;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Support\Traits\FiresCallbacks;
use Illuminate\Support\Facades\View as ViewFacade;

/**
 * Class Ui
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Component implements Arrayable, Jsonable
{
    use Fluency;
    use Macroable;
    use FiresCallbacks;

    use Prototype {
        Prototype::initializePrototype as private initializePrototypeTrait;
    }

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        return $this->initializePrototypeTrait(array_merge([
            'template' => null,
            'component' => null,
            'classes' => [],
            'attributes' => [],
            'data' => new Collection(),
        ], $attributes));
    }

    public function class(array $classes = [])
    {
        return trim($this->class . ' ' . implode(' ', array_merge($this->classes ?: [], $classes))) ?: null;
    }

    public function attributes(array $attributes = [])
    {
        $classes = (array) Arr::pull($attributes, 'classes', []);

        return array_merge([
            'class' => $this->class($classes),
        ], (array) $this->getPrototypeAttribute('attributes', []), $attributes);
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

        if ($this->as) {
            $payload[$this->as] = $this;
        }

        return ViewFacade::make($this->template, $payload);
    }

    public function url()
    {
        if (!$stream = $this->stream) {
            return;
        }

        $type = Str::singular($this->component);
        $default = "/ui/{$stream->handle}/{$type}/{$this->handle}";

        return $this->options->get('url', Config::get('streams.cp.prefix', 'cp') . $default);
    }

    public function request($key, $default = null)
    {
        return Request::get($this->prefix($key), $default);
    }

    public function prefix($target = null): string
    {
        return $this->options->get('prefix') . $target;
    }

    public function __toString()
    {
        return $this->template ? (string) $this->render() : '';
    }
}
