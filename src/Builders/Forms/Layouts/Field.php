<?php

namespace Streams\Ui\Builders\Forms\Layouts;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

class Field extends ViewBuilder
{
    // @todo This is out of place.
    use \Streams\Ui\Builders\Inputs\Concerns\HasHint;

    use Common\BelongsToParent;
    use Common\BelongsToLivewire;
    
    use Common\HasId;
    use Common\HasLabel;
    use Common\HasState;
    use Common\HasComponents;
    use Common\HasHtmlAttributes;
    use Common\CanSpanColumns;
    use Common\CanBeDisabled;

    protected string $viewIdentifier = 'field';

    protected string $view = 'ui::builders.field';

    public function __construct(
        string|array|\Closure|null $label = null
    ) {
        is_array($label)
            ? $this->components($label)
            : $this->label($label);
    }

    public static function make(
        string|array|\Closure|null $label = null
    ): static {
        $instance = app(static::class, ['label' => $label]);

        $instance->configure();

        return $instance;
    }

    protected string|\Closure|null $helpText = null;

    public function helpText(string|\Closure|null $helpText): static
    {
        $this->helpText = $helpText;

        return $this;
    }

    public function getHelpText(): ?string
    {
        return $this->evaluate($this->helpText);
    }

    protected bool|\Closure $required = false;

    public function required(bool|\Closure $condition = true): static
    {
        $this->required = $condition;

        return $this;
    }

    public function isRequired(): bool
    {
        return (bool) $this->evaluate($this->required);
    }
}
