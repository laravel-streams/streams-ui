<?php

namespace Streams\Ui\Support;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\FiresCallbacks;

class UiManager
{

    use Macroable;
    use FiresCallbacks;

    /**
     * Registered UI components.
     *
     * @var array
     */
    protected $components;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->components = [
            'form' => \Streams\Ui\Form\Form::class,
            'table' => \Streams\Ui\Table\Table::class,
            'layout' => \Streams\Ui\Layout\Layout::class,
            'button' => \Streams\Ui\Button\Button::class,
            'cp' => \Streams\Ui\ControlPanel\ControlPanel::class,

            'fields' => \Streams\Ui\Layout\Fields::class,
        ];
    }

    /**
     * Make a new image instance.
     *
     * @param  mixed $source
     * @return Image
     */
    public function make($name, array $attributes = [])
    {
        $component = Arr::get($this->components, $name, 'ui.components.' . $name);

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
