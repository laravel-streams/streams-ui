<?php

namespace Streams\Ui\Builders\Menu;

use Streams\Ui\Builders\Actions\MountableAction;
use Streams\Ui\Builders\Concerns as Common;

class MenuItem extends MountableAction
{
    use Common\HasSortOrder;
}
