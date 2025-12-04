<?php

namespace Streams\Ui\Builders\Tables\Columns;

use Streams\Ui\Builders\Concerns as Support;

class BadgeColumn extends Column
{
    use Support\HasIcon;
    use Support\HasColor;

    protected string $view = 'ui::components.table.columns.badge-column';
}
