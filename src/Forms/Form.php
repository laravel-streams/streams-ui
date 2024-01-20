<?php

namespace Streams\Ui\Forms;

use Livewire\Component;
use Streams\Ui\Traits as Support;
use Streams\Ui\Containers\Container;

class Form extends Container
{
    use Support\HasStream;
    use Support\HasActions;
    use Support\HasHeading;
    use Support\HasDescription;
    
    // use Containers\Concerns\HasContainers;

    protected ?string $statePath = 'form';

    protected string $view = 'ui::form';

    protected string $viewIdentifier = 'form';

    public function __construct(Component $livewire = null)
    {
        $this->livewire($livewire);
    }

    public static function make(Component $livewire = null): static
    {
        $instance = new static($livewire);

        $instance->configure();

        return $instance;
    }

    public function getComponents(bool $withHidden = false): array
    {
        // $components = array_map(function (Component $component): Component {
        $components = array_map(function ($component) {
        
            $component->parent($this);
            $component->livewire($this->getLivewire());

            return $component;
        }, $this->evaluate($this->components));

        if ($withHidden) {
            return $components;
        }

        return array_filter(
            $components,
            // fn (Component $component) => $component->isVisible(),
            fn ($component) => !$component->isHidden(),
        );
    }
}
