<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Streams\Ui\Support\Facades\Breadcrumbs as Collection;

class Breadcrumbs extends Component
{
    public string $template = 'ui::components.breadcrumbs';

    public array $items = [];

    public function onBooted()
    {
        if (!$this->items) {
            $this->items = Collection::all();
        }
    }
}
