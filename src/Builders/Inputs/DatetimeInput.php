<?php

namespace Streams\Ui\Builders\Inputs;

class DatetimeInput extends Input
{
    use Concerns\CanBeDateConstrained;
    use Concerns\HasDatalist;
    use Concerns\HasPlaceholder;
    use Concerns\HasStep;

    protected string $view = 'ui::builders.inputs.datetime';
}
