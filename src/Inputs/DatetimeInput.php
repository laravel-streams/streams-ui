<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Inputs\Traits;

class DatetimeInput extends Input
{
    use Concerns\HasStep;
    use Concerns\HasDatalist;
    use Concerns\HasPlaceholder;

    use Concerns\CanBeDateConstrained;

    protected string $view = 'ui::builders.inputs.datetime';
}
