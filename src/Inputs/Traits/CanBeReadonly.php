<?php

namespace Streams\Ui\Inputs\Traits;

trait CanBeReadonly
{
    protected bool | \Closure | null $readonly = null;

    public function readonly(bool | \Closure | null $readonly): static
    {
        $this->readonly = $readonly;

        return $this;
    }

    public function isReadonly(): bool
    {
        return (bool) $this->evaluate($this->readonly);
    }
}
