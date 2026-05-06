<?php

namespace Streams\Ui\Builders\Tables\Views;

use Streams\Ui\Builders\Tables\Table;
use Streams\Ui\Builders\Tables\Actions\Action;
use Streams\Ui\Builders\Concerns\HasComponents;

class ViewAction extends Action
{
    use HasComponents;

    protected ?\Closure $applyUsing = null;

    public function applyUsing(?\Closure $callback): static
    {
        $this->applyUsing = $callback;

        return $this;
    }

    public function apply(Table $table): mixed
    {
        if (! $this->applyUsing) {
            return null;
        }

        return $this->evaluate($this->applyUsing, [
            'table' => $table,
            'view' => $this,
            'livewire' => $table->getLivewire(),
            'components' => $this->getComponents(),
        ]);
    }
}
