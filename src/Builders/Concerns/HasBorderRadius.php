<?php

namespace Streams\Ui\Builders\Concerns;

trait HasBorderRadius
{
    protected string|\Closure|bool|null $borderRadius = null;

    public function borderRadius(string|\Closure|bool|null $borderRadius): static
    {
        $this->borderRadius = $borderRadius;

        return $this;
    }

    public function getBorderRadius(): string|bool|null
    {
        return $this->evaluate($this->borderRadius);
    }

    public function getBorderRadiusClass(): ?string
    {
        $borderRadius = $this->getBorderRadius();

        if ($borderRadius === null) {
            return null;
        }

        return match ($borderRadius) {
            true => 'rounded',
            'sm' => 'rounded-sm',
            'md' => 'rounded-md',
            'lg' => 'rounded-lg',
            'xl' => 'rounded-xl',
            '2xl' => 'rounded-2xl',
            '3xl' => 'rounded-3xl',
            'full' => 'rounded-full',
            'none' => 'rounded-none',
            default => $borderRadius,
        };
    }
}
