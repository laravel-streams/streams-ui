<?php

namespace Streams\Ui\Pages;

use Streams\Ui\Builders\Panels\Panel;
use Illuminate\Routing\Route;

class PageRouter
{
    public function __construct(
        protected string $page,
        protected \Closure $route,
    ) {
    }

    public function registerRoute(Panel $panel): ?Route
    {
        return ($this->route)($panel);
    }

    public function getPage(): string
    {
        return $this->page;
    }
}
