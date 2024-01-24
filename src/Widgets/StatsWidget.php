<?php

namespace Streams\Ui\Widgets;

class StatsWidget extends Widget
{
    use Traits\CanPoll;

    protected static string $view = 'ui::builders.stats';

    public function getStats(): array
    {
        return [];
    }
}
