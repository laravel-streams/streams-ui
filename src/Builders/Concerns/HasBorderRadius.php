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

    /**
     * Tailwind utility for the configured radius.
     *
     * @param  string|null  $side  null for full radius, or t/b/tl/tr/bl/br (or top/bottom/top-left/…)
     */
    public function getBorderRadiusClass(?string $side = null): ?string
    {
        $borderRadius = $this->getBorderRadius();

        if ($borderRadius === null) {
            return null;
        }

        // Allow passing a raw Tailwind class through borderRadius().
        if (is_string($borderRadius) && str_starts_with($borderRadius, 'rounded')) {
            return $borderRadius;
        }

        $prefix = match ($side) {
            't', 'top' => 'rounded-t',
            'b', 'bottom' => 'rounded-b',
            'tl', 'top-left' => 'rounded-tl',
            'tr', 'top-right' => 'rounded-tr',
            'bl', 'bottom-left' => 'rounded-bl',
            'br', 'bottom-right' => 'rounded-br',
            default => 'rounded',
        };

        $token = $borderRadius === true ? null : (string) $borderRadius;

        if ($token === null || $token === '' || $token === 'DEFAULT') {
            return $prefix;
        }

        if ($token === 'none') {
            return "{$prefix}-none";
        }

        return "{$prefix}-{$token}";
    }

    /**
     * CSS length for the configured radius (for first/last-child clipping without overflow-hidden).
     */
    public function getBorderRadiusCssValue(): ?string
    {
        $borderRadius = $this->getBorderRadius();

        if ($borderRadius === null || $borderRadius === 'none') {
            return null;
        }

        if ($borderRadius === true) {
            return '0.25rem';
        }

        if (! is_string($borderRadius)) {
            return null;
        }

        // Raw Tailwind class passed through — no CSS length available.
        if (str_starts_with($borderRadius, 'rounded')) {
            return null;
        }

        return match ($borderRadius) {
            'sm' => '0.125rem',
            'md' => '0.375rem',
            'lg' => '0.5rem',
            'xl' => '0.75rem',
            '2xl' => '1rem',
            '3xl' => '1.5rem',
            'full' => '9999px',
            default => null,
        };
    }
}
