<?php

namespace Streams\Ui\Builders\Actions;

use Streams\Ui\Builders;
use Streams\Ui\Components\Forms\InteractsWithForms;

class Action extends MountableAction
{
    use Concerns\HasTag;
    use Concerns\HasAction;
    use Concerns\HasArguments;

    use Builders\Concerns\HasUrl;
    use Builders\Concerns\HasIcon;
    use Builders\Concerns\HasName;
    use Builders\Concerns\HasColor;
    use Builders\Concerns\HasLabel;

    use Builders\Concerns\CanBeDisabled;

    use Builders\Concerns\HasHtmlAttributes;
    
    use Builders\Tables\Concerns\BelongsToTable;

    protected string $viewIdentifier = 'action';

    public function __construct(string $name)
    {
        $this->name($name);
    }

    static public function make($name): static
    {
        $static = new static($name);

        $static->configure();

        return $static;
    }

    public function getLabel(): string
    {
        $label = $this->evaluate($this->label)
            ?? ucwords((string) str($this->getName())
                ->beforeLast('.')
                ->afterLast('.')
                ->kebab()
                ->replace(['-', '_'], ' '));

        return $label;
    }
}
