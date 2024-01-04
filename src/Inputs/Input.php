<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Inputs;
use Streams\Ui\Builders\Concerns;
use Streams\Ui\Builders\Containers\Container;
use Streams\Ui\Builders\Containers\Concerns\HasContainers;
use Streams\Ui\Builders\Containers\Concerns\BelongsToContainer;

abstract class Input extends Container
{
    use HasContainers;
    use BelongsToContainer;
    
    use Concerns\HasId;
    use Concerns\HasName;
    use Concerns\HasLabel;
    
    use Concerns\HasHtmlAttributes;
    
    use Concerns\BelongsToLivewire;
    
    use Concerns\CanSpanColumns;
    
    
    use Inputs\Traits\HasKey;
    use Inputs\Traits\HasHint;
    use Inputs\Traits\HasState;
    use Inputs\Traits\HasFieldWrapper;
    
    use Inputs\Traits\CanBeHidden;
    use Inputs\Traits\CanBeDisabled;
    use Inputs\Traits\CanBeReadonly;
    use Inputs\Traits\CanBeValidated;
    use Inputs\Traits\CanBeAutofocused;

    protected string $viewIdentifier = 'field';

    protected string | \Closure | null $helpText = null;

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

    public function helpText(string | \Closure | null $helpText): static
    {
        $this->helpText = $helpText;

        return $this;
    }

    public function getHelpText(): string | null
    {
        return $this->evaluate($this->helpText);
    }
}
