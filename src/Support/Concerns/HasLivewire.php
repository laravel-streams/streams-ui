<?php

namespace Streams\Ui\Builders\Concerns;

use Livewire\Component;

trait HasLivewire
{
    protected Component $livewire;

    public function livewire(Component $livewire): static
    {
        $this->livewire = $livewire;

        return $this;
    }

    public function getLivewire(): Component
    {
        return $this->livewire;
    }
}
