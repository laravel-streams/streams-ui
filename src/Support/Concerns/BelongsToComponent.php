<?php

namespace Streams\Ui\Support\Concerns;

use Streams\Ui\Support\Component;

trait BelongsToComponent
{
    protected ?Component $parentComponent = null;

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
