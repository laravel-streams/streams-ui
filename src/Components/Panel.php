<?php

namespace Streams\Ui\Components;

use Livewire\Component;

//use Streams\Ui\Support\Component;

class Panel extends Component
{
    public string $name = 'admin';
    public string $path = 'admin';

    protected bool $default = false;

    protected string $layout = 'ui::layouts.app';

    protected \Closure | null $routes = null;

    protected array $pages = [];
    protected array $middleware = [];

    protected array $navigationGroups = [];
    protected array $navigationItems = [];

    static public function make(array $attributes = []): static
    {
        $instance = new static;

        array_map(function ($value, $key) use ($instance) {
            $instance->{$key} = $value;
        }, $attributes, array_keys($attributes));

        return $instance;
    }

    public function render(array $payload = []): \Illuminate\View\View
    {
        return view($this->template);
    }

    public function default(): static
    {
        $this->default = true;

        return $this;
    }

    public function isDefault(): bool
    {
        return $this->default;
    }

    public function routes(?\Closure $routes): static
    {
        $this->routes = $routes;

        return $this;
    }

    public function getRoutes(): ?\Closure
    {
        return $this->routes;
    }

    public function pages(array $pages): static
    {
        $this->pages = [
            ...$this->pages,
            ...$pages,
        ];

        return $this;
    }

    public function getPages(): array
    {
        return $this->pages;
    }

    public function middleware(array $middleware): static
    {
        $this->middleware = [
            ...$this->middleware,
            ...$middleware,
        ];

        return $this;
    }

    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    public function getLayout(): string
    {
        return $this->layout;
    }

    public function navigationGroups(array $navigationGroups): static
    {
        $this->navigationGroups = [
            ...$this->navigationGroups,
            ...$navigationGroups,
        ];

        return $this;
    }

    public function getNavigationGroups(): array
    {
        return $this->navigationGroups;
    }

    public function navigationItems(array $navigationItems): static
    {
        $this->navigationItems = [
            ...$this->navigationItems,
            ...$navigationItems,
        ];

        return $this;
    }

    public function getNavigationItems(): array
    {
        return $this->navigationItems;
    }
}
