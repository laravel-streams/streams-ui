<?php

namespace Streams\Ui\Builders\Inputs;

use Streams\Ui\Builders\Inputs\Concerns;

class DatetimeInput extends Input
{
    use Concerns\HasStep;
    use Concerns\HasDatalist;
    use Concerns\HasPlaceholder;

    use Concerns\CanBeDateConstrained;

    protected string $view = 'ui::builders.inputs.datetime';
}
