<?php

namespace Streams\Ui\Builders\Inputs;

class DatetimeInput extends Input
{
    use Traits\CanBeDateConstrained;
    use Traits\HasDatalist;
    use Traits\HasPlaceholder;
    use Traits\HasStep;

    protected string $view = 'ui::builders.inputs.datetime';
}
