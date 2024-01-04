<?php

namespace Streams\Ui\Actions\Traits;

use Streams\Ui\Builders\Forms\Form;
use Streams\Ui\Builders\Containers\Container;

trait CanBeMounted
{
    protected ?\Closure $mountUsing = null;

    public function mount(array $parameters): mixed
    {
        return $this->evaluate($this->getMountUsing(), $parameters);
    }

    public function mountUsing(?\Closure $callback): static
    {
        $this->mountUsing = $callback;

        return $this;
    }

    public function fillForm(array | \Closure $data): static
    {
        $this->mountUsing(function (?Form $form) use ($data) {
            $form?->fill($this->evaluate($data));
        });

        return $this;
    }

    public function getMountUsing(): \Closure
    {
        return $this->mountUsing ?? static function (?Container $form = null): void {
            if (! $form) {
                return;
            }

            $form->fill();
        };
    }
}
