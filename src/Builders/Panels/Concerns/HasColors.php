<?php

namespace Streams\Ui\Builders\Panels\Concerns;

trait HasColors
{
    protected array $colors = [];

    public function colors(array $colors): static
    {
        foreach ($colors as $name => $color) {
            $this->colors[$name] = $color;
        }

        return $this;
    }
}
