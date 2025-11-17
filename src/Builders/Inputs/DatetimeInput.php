<?php

namespace Streams\Ui\Builders\Inputs;

use Streams\Ui\Builders\Inputs\Traits;

class DatetimeInput extends Input
{
    use Traits\HasStep;
    use Traits\HasDatalist;
    use Traits\HasPlaceholder;

    use Traits\CanBeDateConstrained;

    protected string $view = 'ui::builders.inputs.datetime';
}
