<?php

namespace Streams\Ui\Forms;

use Livewire\Component;
use Streams\Ui\Support\Concerns;
use Streams\Ui\Views\ViewContainer;
use Streams\Ui\Views\Concerns\HasContainers;

class Form extends ViewContainer
{
    use HasContainers;

    use Concerns\HasState;
    use Concerns\HasEntry;
    use Concerns\HasStream;
    
    use Concerns\HasHeading;
    use Concerns\HasDescription;

    use Concerns\BelongsToLivewire;

    protected string $view = 'ui::components.form.index';

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
