<?php

namespace Streams\Ui\Builders\Forms\Layouts;

use Livewire\Component;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

class Container extends ViewBuilder
{
    use Common\BelongsToLivewire;
    use Common\CanSpanColumns;
    use Common\HasComponents;
    use Common\HasHtmlAttributes;
    use Common\HasId;

    protected string $view = 'ui::components.form.container';

    protected ?Component $parentComponent = null;

    final public function __construct($livewire = null)
    {
        if ($livewire) {
            $this->livewire($livewire);
        }
    }

    public static function make($livewire = null): static
    {
        $static = app(static::class, ['livewire' => $livewire]);

        $static->configure();

        return $static;
    }

    public function parentComponent(Component $component): static
    {
        $this->parentComponent = $component;

        return $this;
    }

    public function getParentComponent(): ?Component
    {
        return $this->parentComponent;
    }
}
