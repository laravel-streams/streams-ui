<?php

namespace Streams\Ui;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Traits\Macroable;
use Streams\Ui\Testing\TestableComponent;
use Streams\Core\Support\Traits\FiresCallbacks;

class UiManager
{
    use Macroable;
    use FiresCallbacks;

    protected array $components;

    public function __construct()
    {
        $this->components = Config::get('streams.ui.components', []);
    }

    public function exists(string $alias): bool
    {
        return isset($this->components[$alias]);
    }

    public function make(string $alias, array $attributes = []): Component
    {
        if (!isset($this->components[$alias]) && class_exists($alias)) {
            return App::make($alias, [
                'attributes' => $attributes,
            ]);
        }
        
        if (!$component = Arr::get($this->components, $alias)) {
            throw new \Exception("Component [$alias] does not exist.");
        }

        if (is_array($component)) {
            
            $attributes = array_replace_recursive(Arr::except($component, 'component'), $attributes);

            $component = Arr::pull($component, 'component');
        }

        // @todo Callbacks and such
        return App::make($this->components[$component] ?? $component, [
            'attributes' => $attributes,
        ]);
    }

    public function test(string $alias, array $attributes = []): TestableComponent
    {
        return new TestableComponent($this->make($alias, $attributes));
    }

    public function component($alias, $component): static
    {
        $this->components[$alias] = $component;

        return $this;
    }

    public function getComponents()
    {
        return $this->components;
    }
}
