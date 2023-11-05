<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\Route;

class Page extends Component
{
    public ?string $name = null;
    public ?string $path = null;

    protected string $template = 'ui::components.panel';

    protected array $middleware = [];

    public function render(): \Illuminate\View\View|string
    {
        if (strpos($this->template, '<') !== false) {
            return $this->template;
        }

        return view($this->template);
    }

    public function middleware(array $middleware): static
    {
        $this->middleware = [
            ...$this->middleware,
            ...$middleware,
        ];

        return $this;
    }

    public function routes(Panel $panel)
    {
        Route::get($this->path ?: $this->name, static::class)
            ->name($this->name);
    }
}
