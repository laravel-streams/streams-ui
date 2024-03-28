<?php

namespace Streams\Ui\Traits;

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
