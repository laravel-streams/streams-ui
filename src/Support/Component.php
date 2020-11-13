<?php

namespace Streams\Ui\Support;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\View\View as ViewView;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\Fluency;
use Illuminate\Contracts\Support\Jsonable;
use Streams\Core\Support\Traits\Prototype;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Support\Traits\FiresCallbacks;

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
        return trim(implode(' ', array_merge($this->classes ?: [], $classes))) ?: null;
    }

    public function attributes(array $attributes = [])
    {
        $classes = (array) Arr::pull($attributes, 'classes', []);

        return array_filter(array_merge([
            'class' => $this->class($classes),
        ], (array) $this->getPrototypeAttribute('attributes', []), $attributes));
    }

    public function htmlAttributes(array $attributes = [])
    {
        return Arr::htmlAttributes($this->attributes($attributes));
    }

    public function render(): ViewView
    {
        $payload = [
            Str::camel($this->component) => $this,
        ];

        if ($this->as) {
            $payload[$this->as] = $this;
        }

        return View::make($this->template, $payload);
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
