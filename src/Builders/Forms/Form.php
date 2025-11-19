<?php

namespace Streams\Ui\Builders\Forms;

use Livewire\Component;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Support;

class Form extends ViewBuilder
{
    use Support\BelongsToParent;
    use Support\BelongsToLivewire;

    use Support\HasState;
    use Support\HasStream;
    use Support\HasActions;
    use Support\HasHeading;
    use Support\HasComponents;
    use Support\HasDescription;
    use Support\HasHtmlAttributes;

    protected string $view = 'ui::form';

    protected string $viewIdentifier = 'form';

    public function __construct(?Component $livewire = null)
    {
        $this->statePath = 'form';

        $this->livewire($livewire);
    }

    public static function make(?Component $livewire = null): static
    {
        $instance = app(static::class, [
            'livewire' => $livewire,
        ]);

        $instance->configure();

        return $instance;
    }

    public function getComponents(bool $withHidden = false): array
    {
        $components = array_map(function ($component) {

            $component->parent($this);
            $component->livewire($this->getLivewire());

            return $component;
        }, $this->evaluate($this->components));

        if ($withHidden) {
            return $components;
        }

        return $components;

        return array_filter(
            $components,
            fn ($component) => $component->isVisible(),
        );
    }
}
