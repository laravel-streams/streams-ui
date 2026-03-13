<?php

namespace Streams\Ui\Builders\Forms;

use Livewire\Component;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

class Form extends ViewBuilder
{
    use Common\BelongsToParent;
    use Common\BelongsToLivewire;
    
    use Common\HasState;
    use Common\HasStream;
    use Common\HasActions;
    use Common\HasHeading;
    use Common\HasComponents;
    use Common\HasDescription;
    use Common\HasHtmlAttributes;
    
    use Concerns\HandlesValidation;

    protected string $view = 'ui::builders.form';

    protected string $viewIdentifier = 'form';

    public function __construct(?Component $livewire = null)
    {
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

            if ($component instanceof Common\BelongsToLivewire) {
                $component->livewire($this->getLivewire());
            }

            return $component;
        }, $this->evaluate($this->components));

        if ($withHidden) {
            return $components;
        }

        return $components;
    }
}
