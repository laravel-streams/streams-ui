<?php

namespace Streams\Ui\Traits;

use Illuminate\View\ComponentAttributeBag;

trait HasHtmlAttributes
{
    protected array $htmlAttributes = [];

    public function htmlAttributes(array | \Closure $attributes, bool $merge = false): static
    {
        if ($merge) {
            $this->htmlAttributes[] = $attributes;
        } else {
            $this->htmlAttributes = [$attributes];
        }

        return $this;
    }

    public function mergeHtmlAttributes(array | \Closure $attributes): static
    {
        return $this->htmlAttributes($attributes, true);
    }

    public function getHtmlAttributes(): array
    {
        $attributes = new ComponentAttributeBag();

        foreach ($this->htmlAttributes as $htmlAttributes) {
            $attributes = $attributes->merge($this->evaluate($htmlAttributes));
        }

        return $attributes->getAttributes();
    }

    public function hasHtmlAttribute($attribute): bool
    {
        return array_key_exists($attribute, $this->getHtmlAttributes());
    }

    public function getHtmlAttributeBag(): ComponentAttributeBag
    {
        return new ComponentAttributeBag($this->getHtmlAttributes());
    }
}
