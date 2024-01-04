<?php

namespace Streams\Ui\Pages\Traits;

trait HasLayout
{
    protected static string $layout = 'ui::layouts.page';

    protected function getLayoutData(): array
    {
        return [];
    }

    protected function getViewData(): array
    {
        return [];
    }
}
