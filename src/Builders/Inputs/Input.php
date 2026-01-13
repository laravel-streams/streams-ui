<?php

namespace Streams\Ui\Builders\Inputs;

use Streams\Ui\Builders\Inputs;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

abstract class Input extends ViewBuilder
{
    use Common\BelongsToLivewire;
    use Common\CanSpanColumns;
    use Common\HasHtmlAttributes;
    // use BelongsToContainer;

    use Common\HasId;
    use Common\HasLabel;
    use Common\HasName;
    use Common\HasState;
    use Inputs\Concerns\CanBeAutofocused;
    use Inputs\Concerns\CanBeDisabled;
    use Inputs\Concerns\CanBeHidden;
    use Inputs\Concerns\CanBeReadonly;
    use Inputs\Concerns\CanBeValidated;
    use Inputs\Concerns\HasFieldWrapper;
    use Inputs\Concerns\HasHint;
    use Inputs\Concerns\HasKey;

    protected string $viewIdentifier = 'field';

    protected string|\Closure|null $helpText = null;

    final public function __construct(string $name)
    {
        $this->name($name);
        $this->statePath($name);
    }

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);

        $static->configure();

        return $static;
    }

    public function getId(): string
    {
        return $this->id ?: $this->getStatePath();
    }

    public function getKey(): string
    {
        return $this->key ?: $this->getStatePath();
    }

    public function helpText(string|\Closure|null $helpText): static
    {
        $this->helpText = $helpText;

        return $this;
    }

    public function getHelpText(): ?string
    {
        return $this->evaluate($this->helpText);
    }
}
