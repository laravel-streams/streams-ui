<?php

namespace Streams\Ui\Support;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Ui\View\AreaCollection;
use Streams\Ui\View\AreaItem;

class UiManager
{

    use Macroable;
    use FiresCallbacks;

    protected array $components;

    public function __construct()
    {
        $this->components = Config::get('streams.ui.components', []);
    }

    public function make(string $name, array $attributes = [])
    {
        if (!$component = Arr::get($this->components, $name)) {
            throw new \Exception("Component [$name] does not exist.");
        }

        return App::make($component, [
            'attributes' => $attributes,
        ]);
    }

    /**
     * Register a named image.
     *
     * @param string $name
     * @param mixed $component
     * @return $this
     */
    public function register($name, $component)
    {
        $this->components[$name] = $component;

        return $this;
    }
}
