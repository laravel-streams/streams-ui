<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Facades\View;
use Livewire\Component;
use Streams\Core\View\ViewTemplate;
//use Streams\Ui\Support\Component;

class NavigationGroup extends Component
{
    public string $name;
    public string $label;

    protected string $template = 'ui::components.navigation_group';

    public function render(array $payload = []): \Illuminate\View\View|string
    {
        if (strpos($this->template, '<') !== false) {
            return ViewTemplate::make($this->template, $payload);
        }

        return View::make($this->template);
    }

    static public function make(array $attributes = []): self
    {
        $instance = new static;

        array_map(function ($value, $key) use ($instance) {
            $instance->{$key} = $value;
        }, $attributes, array_keys($attributes));

        return $instance;
    }
}
