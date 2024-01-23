<?php

namespace Streams\Ui\Widgets;

use Livewire\Component;
use Streams\Ui\Traits as Common;
use Illuminate\Contracts\View\View;

class Widget extends Component
{
    protected static string $view;

    public function render(): View
    {
        return view(static::$view, $this->getViewData());
    }

    protected function getViewData(): array
    {
        return [];
    }
}
