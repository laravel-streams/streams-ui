<?php

namespace Streams\Ui\Livewire\Pages;

use Illuminate\Routing\Route;
use Streams\Ui\Builders\Panels\Panel;

class PageRouter
{
    public function __construct(
        protected string $page,
        protected \Closure $route,
    ) {}

    public function registerRoute(Panel $panel): ?Route
    {
        return ($this->route)($panel);
    }

    public function getPage(): string
    {
        return $this->page;
    }
}
