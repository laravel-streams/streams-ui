<?php

namespace Streams\Ui\Builders\Forms\Layouts;

use Streams\Ui\Traits\HasColumns;
use Streams\Ui\Builders\Component;
use Streams\Ui\Builders\ViewComponent;
use Streams\Ui\Builders\Concerns\HasId;
use Streams\Ui\Builders\Concerns\HasLivewire;
use Streams\Ui\Builders\Concerns\CanSpanColumns;
use Streams\Ui\Builders\Concerns\HasHtmlAttributes;
use Streams\Ui\Builders\Forms\Concerns\HasComponents;

class Container extends ViewComponent
{
    use CanSpanColumns;
    use HasColumns;
    use HasComponents;
    use HasHtmlAttributes;
    use HasId;
    use HasLivewire;

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
