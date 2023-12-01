<?php

namespace Streams\Ui\Support\Concerns;

use Illuminate\View\ComponentAttributeBag;

trait HasAlpineAttributes
{
    protected array $alpineAttributes = [];

    public function alpineAttributes(
        array | \Closure $attributes,
        bool $merge = false
    ): static {
        
        if ($merge) {
            $this->alpineAttributes[] = $attributes;
        } else {
            $this->alpineAttributes = [$attributes];
        }

        return $this;
    }

    public function getAlpineAttributes(): array
    {
        $attributes = new ComponentAttributeBag();

        foreach ($this->alpineAttributes as $alpineAttributes) {
            $attributes = $attributes->merge(
                $this->evaluate($alpineAttributes)
            );
        }

        return $attributes->getAttributes();
    }

    public function getAlpineAttributeBag(): ComponentAttributeBag
    {
        return new ComponentAttributeBag($this->getAlpineAttributes());
    }
}
