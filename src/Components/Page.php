<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Facades\Route;
use Livewire\Component;
use Streams\Ui\Support\Facades\UI;

class Page extends Component
{
    protected ?string $name = null;
    protected ?string $path = null;

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

    static public function routes(Panel $panel)
    {
        $self = new static;

        Route::get($self->path ?: $self->name, static::class)
            ->name($self->name);
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
