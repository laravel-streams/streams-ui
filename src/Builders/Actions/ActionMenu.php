<?php

namespace Streams\Ui\Builders\Actions;

use Streams\Ui\Builders\Concerns as Common;

class ActionMenu extends Action
{
    use Common\HasActions;

    protected string $view = 'ui::builders.action-menu';
}
