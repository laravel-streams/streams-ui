<?php

namespace Streams\Ui\Builders\Concerns;

trait HasInset
{
    protected string|\Closure|bool|null $inset = null;

    public function inset(string|\Closure|bool|null $inset): static
    {
        $this->inset = $inset;

        return $this;
    }

    public function getInset(): string|bool|null
    {
        return $this->evaluate($this->inset);
    }

    public function getInsetClass(string $prefix = 'p'): ?string
    {
        $inset = $this->getInset();

        if ($inset === null) {
            return null;
        }

        if ($inset === false || $inset === 'none') {
            return "{$prefix}-0";
        }

        if ($inset === true) {
            $inset = 'm';
        }

        if (is_string($inset) && str_contains($inset, '-')) {
            return $inset;
        }

        $size = match ($inset) {
            'xs' => '2',
            's' => '4',
            'm' => '6',
            'l' => '8',
            'xl' => '10',
            '2xl' => '12',
            default => null,
        };

        if ($size === null) {
            return null;
        }

        return "{$prefix}-{$size}";
    }

    public function getInsetPaddingClass(string $prefix = 'p', ?string $default = null): ?string
    {
        return $this->getInsetClass($prefix) ?? $default;
    }
}
