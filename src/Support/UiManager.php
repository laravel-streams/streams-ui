<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
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
        $this->components = [
            // 'form' => \Streams\Ui\Components\Form::class,
            // 'alert' => \Streams\Ui\Components\Alert::class,
            // 'table' => \Streams\Ui\Components\Table::class,
            // 'modal' => \Streams\Ui\Components\Modal::class,
            // 'field' => \Streams\Ui\Components\Field::class,
            // 'avatar' => \Streams\Ui\Components\Avatar::class,
            // 'cp' => \Streams\Ui\Components\ControlPanel::class,
            // 'dropdown' => \Streams\Ui\Components\Dropdown::class,
            
            'button' => \Streams\Ui\Components\Button::class,


            // 'time' => \Streams\Ui\Components\Input::class,
            // 'datetime' => \Streams\Ui\Components\Input::class,

            // 'date' => \Streams\Ui\Components\Inputs\Date::class,
            // 'slug' => \Streams\Ui\Components\Inputs\Slug::class,
            // 'tags' => \Streams\Ui\Components\Inputs\Tags::class,
            // 'array' => \Streams\Ui\Components\Inputs\Tags::class,
            // 'number' => \Streams\Ui\Components\Inputs\Number::class,
            // 'editor' => \Streams\Ui\Components\Inputs\Editor::class,
            // 'decimal' => \Streams\Ui\Components\Inputs\Decimal::class,
            // 'integer' => \Streams\Ui\Components\Inputs\Integer::class,
            // 'markdown' => \Streams\Ui\Components\Inputs\Markdown::class,
            // 'checkboxes' => \Streams\Ui\Components\Inputs\Checkboxes::class,
            // 'relationship' => \Streams\Ui\Components\Inputs\Relationship::class,

            'url' => \Streams\Ui\Components\Input::class,
            'file' => \Streams\Ui\Components\Input::class,
            'hash' => \Streams\Ui\Components\Input::class,
            'uuid' => \Streams\Ui\Components\Input::class,
            'email' => \Streams\Ui\Components\Input::class,
            'object' => \Streams\Ui\Components\Input::class,


            'enum' => \Streams\Ui\Components\Inputs\SelectInput::class,
            'select' => \Streams\Ui\Components\Inputs\SelectInput::class,

            'color' => \Streams\Ui\Components\Inputs\ColorInput::class,

            'text' => \Streams\Ui\Components\Inputs\TextInput::class,
            'input' => \Streams\Ui\Components\Inputs\TextInput::class,
            'string' => \Streams\Ui\Components\Inputs\TextInput::class,

            'boolean' => \Streams\Ui\Components\Inputs\CheckboxInput::class,
            'checkbox' => \Streams\Ui\Components\Inputs\CheckboxInput::class,

            'textarea' => \Streams\Ui\Components\Inputs\TextareaInput::class,
        ];
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

        return $instance;
    }

    public function getComponents()
    {
        return $this->components;
    }

    public function newInstance(string $name, array $attributes = []): Component
    {
        if (!$component = Arr::get($this->components, $name)) {
            throw new \Exception("Component [$name] is not registered.");
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
