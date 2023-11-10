<?php

namespace Streams\Ui\Components\Table\Column;

class TextColumn
{
    protected string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    static public function make($name): static
    {
        $static = new static($name);

        return $static;
    }

    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function value($entry): string
    {
        return $entry->{$this->name};
    }
}
