<?php

namespace Streams\Ui\Components\Breadcrumbs;

use Streams\Ui\Components\Breadcrumbs\Breadcrumbs;

class BreadcrumbsManager
{
    public function make(array $items = []): Breadcrumbs
    {
        return Breadcrumbs::make($items);
    }
}
