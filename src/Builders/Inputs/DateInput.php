<?php

namespace Streams\Ui\Builders\Inputs;

class DateInput extends Input
{
    use Traits\CanBeAutocompleted;
    use Traits\CanBeDateConstrained;
    use Traits\HasDatalist;
    use Traits\HasPlaceholder;
    use Traits\HasStep;

    protected string $view = 'ui::builders.inputs.date';
}
