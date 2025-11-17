<?php

namespace Streams\Ui\Builders\Tables\Columns;

use Streams\Ui\Traits as Support;

class IconColumn extends Column
{
    use Support\HasSize;

    protected string $view = 'ui::components.table.columns.icon-column';
}
