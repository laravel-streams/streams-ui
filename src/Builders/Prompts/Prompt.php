<?php

namespace Streams\Ui\Builders\Prompts;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Actions\Action;
use Streams\Ui\Builders\Concerns as Common;

abstract class Prompt extends ViewBuilder
{
    use Common\HasActions;
    use Common\HasHtmlAttributes;
    use Common\HasText;

    protected string|\Closure|null $align = 'left';

    protected string|\Closure|null $size = 'md';

    protected bool|\Closure $muted = false;

    public static function make(): static
    {
        $instance = app(static::class);

        $instance->configure();

        return $instance;
    }

    public function action(Action $action): static
    {
        return $this->actions([$action]);
    }

    public function align(string|\Closure|null $align): static
    {
        $this->align = $align;

        return $this;
    }

    public function getAlign(): ?string
    {
        return $this->evaluate($this->align);
    }

    public function size(string|\Closure|null $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->evaluate($this->size);
    }

    public function muted(bool|\Closure $muted = true): static
    {
        $this->muted = $muted;

        return $this;
    }

    public function isMuted(): bool
    {
        return (bool) $this->evaluate($this->muted);
    }
}
