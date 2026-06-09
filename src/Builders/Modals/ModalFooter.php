<?php

namespace Streams\Ui\Builders\Modals;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

class ModalFooter extends ViewBuilder
{
    use Common\HasActions;
    use Common\HasHtmlAttributes;

    protected string $viewIdentifier = 'modalFooter';

    protected string $view = 'ui::builders.modal-footer';

    public static function make(): static
    {
        $instance = app(static::class);

        $instance->configure();

        return $instance;
    }
}
