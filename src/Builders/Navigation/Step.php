<?php

namespace Streams\Ui\Builders\Navigation;

use Illuminate\Support\Str;
use Streams\Ui\Builders\Builder;
use Streams\Ui\Builders\Concerns;

class Step extends Builder
{
    use Concerns\HasLabel;

    public function __construct(string $label)
    {
        $this->label($label);
    }

    public static function make(?string $label = null): static
    {
        $label = $label ?? self::getDefaultLabel();

        $static = new static($label);

        $static->configure();

        return $static;
    }

    protected static function getDefaultLabel(): string
    {
        $parts = explode('\\', static::class);

        return Str::title(end($parts));
    }
}
