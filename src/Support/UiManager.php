<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Macroable;
use Streams\Ui\Support\Javascript\Config;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Ui\Support\Javascript\ServiceProviderCollection;

class UiManager
{

    use Macroable;
    use FiresCallbacks;

    /**
     * Registered UI components.
     *
     * @var array<string,string>
     */
    protected array $components;

    /** Javascript Application Configuration */
    protected Config $config;

    /** Javascript Application Service Providers */
    protected ServiceProviderCollection $providers;


    public function __construct()
    {
        $this->config = new Config();
        $this->providers = new ServiceProviderCollection();

        $this->components = [
            'form' => \Streams\Ui\Form\Form::class,
            'table' => \Streams\Ui\Table\Table::class,
            'button' => \Streams\Ui\Button\Button::class,
        ];
    }

    public function make(string $name, array $attributes = []): Component
    {
        if (!$component = Arr::get($this->components, $name)) {
            throw new \Exception("Component [$name] does not exist.");
        }

        return App::make($component, [
            'attributes' => $attributes,
        ]);
    }

    public function register($name, $component): static
    {
        $this->components[$name] = $component;

        return $this;
    }

    public function config(): Config
    {
        return $this->config;
    }

    public function providers(): ServiceProviderCollection
    {
        return $this->providers;
    }
}
