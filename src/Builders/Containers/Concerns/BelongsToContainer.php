<?php

namespace Streams\Ui\Builders\Containers\Concerns;

use Streams\Ui\Builders\ViewBuilder;

trait BelongsToContainer
{
    protected ?ViewBuilder $parentContainer = null;

    public function parentComponent(ViewBuilder $container): static
    {
        $this->parentContainer = $container;

        return $this;
    }

    public function getParentComponent(): ?ViewBuilder
    {
        return $this->parentContainer;
    }
}
