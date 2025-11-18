<?php

namespace Streams\Ui\Components\Breadcrumbs;

class BreadcrumbsManager
{
    public function make(array $items = []): Breadcrumbs
    {
        return Breadcrumbs::make($items);
    }
}
