<?php

namespace Streams\Ui\Builders\Tables\Filters;

use Streams\Ui\Builders;

class SelectFilter extends Filter
{
    use Builders\Concerns\HasLabel;
    use Builders\Inputs\Traits\HasOptions;
}
