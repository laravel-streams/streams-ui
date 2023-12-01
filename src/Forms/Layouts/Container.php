<?php

namespace Streams\Ui\Forms\Layouts;

use Streams\Ui\Support\ViewComponent;
use Streams\Ui\Support\Concerns\HasId;
use Streams\Ui\Support\Concerns\HasColumns;
use Streams\Ui\Forms\Concerns\HasComponents;
use Streams\Ui\Support\Component;
use Streams\Ui\Support\Concerns\HasLivewire;
use Streams\Ui\Support\Concerns\CanSpanColumns;
use Streams\Ui\Support\Concerns\HasHtmlAttributes;

class Container extends ViewComponent
{
    use HasId;
    use HasColumns;
    use HasLivewire;
    use HasComponents;
    use HasHtmlAttributes;

    use CanSpanColumns;

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
