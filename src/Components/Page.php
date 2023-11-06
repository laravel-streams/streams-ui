<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\Route;
use Streams\Ui\Support\Facades\UI;

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

    public function getNavigationItem(): NavigationItem
    {
        $panel = UI::getCurrentPanel();

        return NavigationItem::make([
            'title' => $this->title,
            'url' => route(implode('/', array_filter([
                $panel->path,
                $this->path ?: $this->name,
            ]))),
            //'icon' => Icon::make(),
            //'badge' => Indicator::make([]),
            //'group' => $this->navigationGroup,
            //'sort' => $this->navigationSort,
            'active' => request()->routeIs("streams.ui.{$panel->name}.{$this->name}"),
        ]);

        // NavigationItem::make(static::getNavigationLabel())
        //         ->group(static::getNavigationGroup())
        //         ->icon(static::getNavigationIcon())
        //         ->activeIcon(static::getActiveNavigationIcon())
        //         ->isActiveWhen(fn (): bool => request()->routeIs(static::getRouteName()))
        //         ->sort(static::getNavigationSort())
    }
}
