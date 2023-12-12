<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Inputs\Concerns;
use Streams\Ui\Views\ViewContainer;
use Streams\Ui\Builders\Concerns\HasId;
use Streams\Ui\Builders\Concerns\HasName;
use Streams\Ui\Builders\Concerns\HasLabel;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Ui\Forms\Concerns\HasFieldWrapper;
use Streams\Ui\Builders\Concerns\BelongsToLivewire;
use Streams\Ui\Builders\Concerns\CanSpanColumns;
use Streams\Ui\Views\Concerns\BelongsToContainer;
use Streams\Ui\Builders\Concerns\HasHtmlAttributes;
use Streams\Ui\Views\Concerns\HasContainers;

abstract class Input extends ViewContainer
{
    use HasId;
    use HasName;
    use HasLabel;
    use HasMemory;
    use HasContainers;
    
    use HasFieldWrapper;
    use HasHtmlAttributes;
    
    use BelongsToLivewire;
    use BelongsToContainer;

    use CanSpanColumns;


    use Concerns\HasKey;
    use Concerns\HasHint;
    use Concerns\HasState;
    

    use Concerns\CanBeHidden;
    use Concerns\CanBeDisabled;
    use Concerns\CanBeReadonly;
    use Concerns\CanBeValidated;
    use Concerns\CanBeAutofocused;

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
