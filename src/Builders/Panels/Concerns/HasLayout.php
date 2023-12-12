<?php

namespace Streams\Ui\Builders\Panels\Concerns;

trait HasLayout
{
    protected string $layout = 'ui::layouts.app';
    
    public function layout(string $layout): static
    {
        $this->layout = $layout;

        return $this;
    }

    public function getLayout(): string
    {
        return $this->layout;
    }
}
