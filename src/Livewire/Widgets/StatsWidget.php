<?php

namespace Streams\Ui\Livewire\Widgets;

class StatsWidget extends Widget
{
    use Concerns\CanPoll;

    protected static string $view = 'ui::builders.stats';

    public function getStats(): array
    {
        return [];
    }
}
