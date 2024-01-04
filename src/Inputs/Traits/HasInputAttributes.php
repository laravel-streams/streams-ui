<?php

namespace Streams\Ui\Inputs\Traits;

use Illuminate\View\ComponentAttributeBag;

trait HasInputAttributes
{
    protected array $inputAttributes = [];

    public function inputAttributes(
        array | \Closure $attributes,
        bool $merge = false
    ): static {
        
        if ($merge) {
            $this->inputAttributes[] = $attributes;
        } else {
            $this->inputAttributes = [$attributes];
        }

        return $this;
    }

    public function getInputAttributes(): array
    {
        $attributes = new ComponentAttributeBag();

        foreach ($this->inputAttributes as $inputAttributes) {
            $attributes = $attributes->merge(
                $this->evaluate($inputAttributes)
            );
        }

        return $attributes->getAttributes();
    }

    public function getInputAttributeBag(): ComponentAttributeBag
    {
        return new ComponentAttributeBag($this->getInputAttributes());
    }
}
