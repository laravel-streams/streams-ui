<?php

namespace Streams\Ui\Builders\Inputs\Concerns;

trait HasFieldWrapper
{
    protected string | \Closure | null $fieldWrapperView = null;

    public function fieldWrapper(string | \Closure | null $view): static
    {
        $this->fieldWrapperView = $view;

        return $this;
    }

    public function getFieldWrapperView(): ?string
    {
        return $this->evaluate($this->fieldWrapperView) ?? 'ui::field';
    }
}
