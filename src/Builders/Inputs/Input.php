<?php

namespace Streams\Ui\Builders\Inputs;

use Streams\Ui\Builders\Inputs;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

abstract class Input extends ViewBuilder
{
    use Inputs\Traits\CanBeAutofocused;
    use Inputs\Traits\CanBeDisabled;
    use Inputs\Traits\CanBeHidden;
    use Inputs\Traits\CanBeReadonly;
    use Inputs\Traits\CanBeValidated;
    use Inputs\Traits\HasFieldWrapper;
    use Inputs\Traits\HasHint;
    use Inputs\Traits\HasKey;
    use Common\CanSpanColumns;
    use Common\BelongsToLivewire;
    use Common\HasHtmlAttributes;
    // use BelongsToContainer;

    use Common\HasId;
    use Common\HasLabel;
    use Common\HasName;
    use Common\HasState;

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
