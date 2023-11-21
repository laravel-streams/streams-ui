<?php

namespace Streams\Ui\Panels\Concerns;

trait HasPages
{
    protected array $pages = [];

    public function pages(array $pages): static
    {
        $this->pages = [
            ...$this->pages,
            ...$pages,
        ];

        foreach ($pages as $page) {
            $this->queueLivewireComponent($page);
        }

        return $this;
    }

    public function getPages(): array
    {
        return array_unique($this->pages);
    }
}
