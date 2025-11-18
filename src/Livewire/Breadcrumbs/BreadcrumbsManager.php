<?php

namespace Streams\Ui\Livewire\Breadcrumbs;

class BreadcrumbsManager
{
    public function make(array $items = []): Breadcrumbs
    {
        return Breadcrumbs::make($items);
    }
}
