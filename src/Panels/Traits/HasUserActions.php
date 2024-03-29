<?php

namespace Streams\Ui\Panels\Traits;

use Streams\Ui\Actions\Action;

trait HasUserActions
{
    protected array $userActions = [];

    public function userActions(array $items): static
    {
        $this->userActions = [
            ...$this->userActions,
            ...$items,
        ];

        return $this;
    }

    public function getUserActions(): array
    {
        return collect($this->userActions)
            ->filter(fn (Action $item): bool => $item->isVisible())
            // ->sort(fn (Action $item): int => $item->getSort())
            ->all();
    }
}
