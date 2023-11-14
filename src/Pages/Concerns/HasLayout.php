<?php

namespace Streams\Ui\Pages\Concerns;

trait HasLayout
{
    protected static string $layout = 'ui::layouts.app';

    protected function getLayoutData(): array
    {
        return [];
    }

    protected function getViewData(): array
    {
        return [];
    }
}
