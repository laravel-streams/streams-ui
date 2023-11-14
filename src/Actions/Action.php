<?php

namespace Streams\Ui\Actions;

use Streams\Ui\Support\Concerns;
use Streams\Ui\Support\Component;

class Action extends Component
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
