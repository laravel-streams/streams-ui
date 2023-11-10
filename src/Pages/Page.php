<?php

namespace Streams\Ui\Pages;

use Livewire\Component;
use Streams\Ui\Pages\Concerns;
use Illuminate\Support\Facades\View;

abstract class Page extends Component
{
    use Concerns\HasRoutes;

    protected static ?string $title = null;

    protected static string $layout = 'ui::layouts.app';

    protected static string $view;

    public function render()
    {
        return View::make(static::$view, $this->getViewData())
            ->layout(static::$layout, [
                'livewire' => $this,
                ...$this->getLayoutData(),
            ]);
    }

    public function getTitle(): string
    {
        return static::$title ?? (string) str(class_basename(static::class))
            ->kebab()
            ->replace('-', ' ')
            ->title();
    }

    protected function getLayoutData(): array
    {
        return [];
    }

    protected function getViewData(): array
    {
        return [];
    }
}
