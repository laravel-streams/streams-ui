<?php

namespace Streams\Ui\Widgets;

use Livewire\Component;
use Streams\Ui\Traits as Common;
use Illuminate\Contracts\View\View;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\FiresCallbacks;

abstract class Widget extends Component
{
    use Common\CanSpanColumns;
    use Common\EvaluatesClosures;
    use FiresCallbacks;
    use HasMemory;

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
