<?php

namespace Streams\Ui\Views\Concerns;

use Streams\Ui\Views\ViewContainer;

trait BelongsToContainer
{
    protected ?ViewContainer $parentContainer = null;

    public function parentComponent(ViewContainer $container): static
    {
        $this->parentContainer = $container;

        return $this;
    }

    public function getParentComponent(): ?ViewContainer
    {
        return $this->parentContainer;
    }
}
