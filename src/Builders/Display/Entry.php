<?php

namespace Streams\Ui\Builders\Display;

class Entry
{
    protected mixed $state = null;

    final public function __construct(protected string $name, protected ?string $label = null)
    {
    }

    public static function make(string $name, ?string $label = null): static
    {
        return new static($name, $label);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label ?? str($this->name)->headline()->toString();
    }

    public function state(mixed $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getState(): mixed
    {
        return $this->state;
    }
}
