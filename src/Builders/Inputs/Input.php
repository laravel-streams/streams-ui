<?php

namespace Streams\Ui\Builders\Inputs;

use Livewire\Component;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

abstract class Input extends ViewBuilder
{
    use Common\BelongsToLivewire;
    use Common\CanSpanColumns;
    use Common\HasHtmlAttributes;
    // use BelongsToContainer;

    use Common\HasBorderRadius;
    use Common\HasId;
    use Common\HasLabel;
    use Common\HasName;
    use Common\HasState;
    use Concerns\CanBeAutofocused;
    use Concerns\CanBeDisabled;
    use Concerns\CanBeHidden;
    use Concerns\CanBeReadonly;
    use Concerns\CanBeValidated;
    use Concerns\HasFieldWrapper;
    use Concerns\HasHint;
    use Concerns\HasKey;

    protected string $viewIdentifier = 'field';

    protected string|\Closure|null $helpText = null;

    final public function __construct(string $name)
    {
        $this->name($name);
    }

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);

        $static->configure();

        return $static;
    }

    public static function for(Component $livewire, string $name): static
    {
        $static = app(static::class, ['name' => $name]);

        $static->livewire($livewire);
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

    protected function resolveDefaultClosureDependency(string $parameter): array
    {
        return match ($parameter) {
            'component' => [$this],
            default => parent::resolveDefaultClosureDependency($parameter),
        };
    }
}
