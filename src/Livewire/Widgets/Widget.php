<?php

namespace Streams\Ui\Livewire\Widgets;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Ui\Builders\Concerns as Common;
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
