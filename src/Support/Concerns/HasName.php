<?php

namespace Streams\Ui\Builders\Concerns;

trait HasName
{
    protected string $name;

    public function name(string $name)
    {
        $this->name = $name;

        return $this;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
}
