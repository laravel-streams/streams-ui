<?php

namespace Streams\Ui\Builders\Inputs;

class DateInput extends Input
{
    use Concerns\CanBeAutocompleted;
    use Concerns\CanBeDateConstrained;
    use Concerns\HasDatalist;
    use Concerns\HasPlaceholder;
    use Concerns\HasStep;

    protected string $view = 'ui::builders.inputs.date';
}
