<?php

namespace Streams\Ui\Panels\Traits;

use Streams\Ui\Menu\MenuItem;

trait HasUserMenu
{
    protected array $userMenuItems = [];

    public function userMenuItems(array $items): static
    {
        $this->userMenuItems = [
            ...$this->userMenuItems,
            ...$items,
        ];

        return $this;
    }

    public function getUserMenuItems(): array
    {
        return $this->userMenuItems;
    }

    public function getUserMenu(): array
    {
        return collect($this->userMenuItems)
            ->filter(fn (MenuItem $item): bool => $item->isVisible())
            ->sort(fn (MenuItem $item): int => $item->getSort())
            ->all();
    }
}
