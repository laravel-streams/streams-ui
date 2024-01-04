<?php

namespace Streams\Ui\Builders\Forms;

use Livewire\Component;
use Streams\Ui\Builders\Concerns;
use Streams\Ui\Builders\Containers;

class Form extends Containers\Container
{
    use Concerns\HasState;
    use Concerns\HasEntry;
    use Concerns\HasStream;
    
    use Concerns\HasActions;
    use Concerns\HasHeading;
    use Concerns\HasDescription;

    use Concerns\BelongsToLivewire;

    use Containers\Concerns\HasContainers;

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
        
            $component->parentComponent($this);
            $component->livewire($this->getLivewire());

            return $component;
        }, $this->evaluate($this->components));

        if ($withHidden) {
            return $components;
        }

        return array_filter(
            $components,
            // fn (Component $component) => $component->isVisible(),
            fn ($component) => $component->isVisible(),
        );
    }
}
