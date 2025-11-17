<?php

namespace Streams\Ui\Builders\Tables\Columns;

use Streams\Ui\Traits as Support;

class LinkColumn extends Column
{
    use Support\HasUrl;

    protected string $view = 'ui::components.table.columns.link-column';
}
