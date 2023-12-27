<?php

namespace Streams\Ui\Builders\Actions;

use Streams\Ui\Builders;

class Action extends Builders\ViewBuilder
{
    use Concerns\HasAction;
    
    use Builders\Concerns\HasUrl;
    use Builders\Concerns\HasIcon;
    use Builders\Concerns\HasName;
    use Builders\Concerns\HasColor;
    use Builders\Concerns\HasLabel;

    protected string $view = 'ui::builders.action';

    protected string $viewIdentifier = 'action';

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
