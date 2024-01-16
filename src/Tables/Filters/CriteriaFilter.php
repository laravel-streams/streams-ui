<?php

namespace Streams\Ui\Tables\Filters;

use Streams\Ui\Inputs;
use Streams\Ui\Builders;

class SelectFilter extends Filter
{
    use Inputs\Traits\HasOptions;
    use Builders\Concerns\HasLabel;
}
