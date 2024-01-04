<?php

namespace Streams\Ui\Actions\Traits;

trait HasAction
{
    protected \Closure | string | null $action = null;

    public function action(\Closure | string | null $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function getAction(): ?\Closure
    {
        if (!$this->action instanceof \Closure) {
            return null;
        }

        return $this->action;
    }
}
