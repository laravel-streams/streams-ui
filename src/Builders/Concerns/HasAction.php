<?php

namespace Streams\Ui\Builders\Concerns;

use Streams\Ui\Builders\Actions\Action;

trait HasAction
{
    protected Action|\Closure|null $action = null;

    public function action(Action|\Closure|null $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function getAction(): Action|null
    {
        return $this->evaluate($this->action);
    }
}
