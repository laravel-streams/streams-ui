<?php

namespace Streams\Ui\Builders\Actions;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Builders\Concerns;

class Action extends Builder
{
    use Concerns\HasUrl;
    use Concerns\HasIcon;
    use Concerns\HasName;
    use Concerns\HasLabel;

    public function __construct(string $name)
    {
        $this->name($name);
    }

    static public function make($name): static
    {
        $static = new static($name);

        return $static;
    }

    public function getLabel(): string
    {
        $label = $this->evaluate($this->label) ?? (string) str($this->getName())
            ->beforeLast('.')
            ->afterLast('.')
            ->kebab()
            ->replace(['-', '_'], ' ')
            ->ucfirst();

        return $label;
    }
}
