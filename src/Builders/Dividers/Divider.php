<?php

namespace Streams\Ui\Builders\Dividers;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

final class Divider extends ViewBuilder
{
    use Common\HasHtmlAttributes;

    protected string $viewIdentifier = 'divider';

    protected string $view = 'ui::builders.divider';

    public static function make(): static
    {
        $instance = app(self::class);

        $instance->configure();

        return $instance;
    }
}
