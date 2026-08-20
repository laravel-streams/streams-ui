<?php

namespace Streams\Ui\Builders\Modals\Concerns;

use Closure;
use Streams\Ui\Builders\Actions\Action;
use Streams\Ui\Builders\Modals\CloseAction;

trait HasCloseAction
{
    protected Action|bool|Closure|null $closeAction = null;

    /**
     * @param  Action|bool|Closure|null  $action  Pass false to hide; Closure receives the default CloseAction.
     */
    public function closeAction(Action|bool|Closure|null $action = null): static
    {
        $this->closeAction = $action;

        return $this;
    }

    public function getCloseAction(): ?Action
    {
        $action = CloseAction::make();

        if ($this->closeAction !== null) {
            $action = $this->evaluate($this->closeAction, ['action' => $action]) ?? $action;
        }

        if ($action === false) {
            return null;
        }

        return $action;
    }

    public function hasCloseAction(): bool
    {
        return $this->getCloseAction() !== null;
    }
}
