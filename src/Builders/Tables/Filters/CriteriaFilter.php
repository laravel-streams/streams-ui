<?php

namespace Streams\Ui\Builders\Tables\Filters;

use Streams\Ui\Builders;
use Streams\Ui\Builders\Inputs;

class SelectFilter extends Filter
{
    use Builders\Concerns\HasLabel;
    use Inputs\Concerns\HasOptions;
}
