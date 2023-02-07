<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\FiresCallbacks;

class UiManager
{
    use Macroable;
    use FiresCallbacks;

    protected array $booted = [];

    protected array $components;

    public function __construct()
    {
        $this->components = Config::get('streams.ui.components', []);
    }

    public function register(string $name, $component): static
    {
        $this->components[$name] = $component;

        return $this;
    }

    public function exists(string $name): bool
    {
        return isset($this->components[$name]);
    }

    public function make(string $name, array $attributes = []): Component
    {
        $attributes['handle'] = Arr::get($attributes, 'handle', $name);

        $instance = $this->newInstance($name, $attributes);

        $this->bootIfNotBooted($name, $instance);

        if (method_exists($instance, 'booted')) {
            $instance->booted();
        }

        return $instance;
    }

    public function getComponents()
    {
        return $this->components;
    }

    public function newInstance(string $name, array $attributes = []): Component
    {
        $component = Arr::get($this->components, $name, $name);

        if (is_string($component) && class_exists($component)) {
            return new $component($attributes);
        }

        if (is_callable($component)) {
            return $component($attributes);
        }

        return App::make($component, [
            'attributes' => $attributes,
        ]);
    }

    public function bootIfNotBooted(string $name, Component $component): void
    {
        if (array_key_exists($name, $this->booted)) {
            return;
        }

        if (method_exists($component, 'boot')) {
            $component->boot();
        }

        $this->booted[$name] = true;
    }
}
