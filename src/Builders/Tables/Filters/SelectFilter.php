<?php

namespace Streams\Ui\Builders\Tables\Filters;

use Streams\Ui\Builders;

class SelectFilter extends Filter
{
    use Builders\Concerns\HasLabel;
    use Builders\Inputs\Concerns\HasOptions;

    protected string $view = 'ui::builders.filters.select';
}
