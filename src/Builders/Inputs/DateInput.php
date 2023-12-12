<?php

namespace Streams\Ui\Builders\Inputs;

class DateInput extends Input
{
    use Concerns\HasStep;
    use Concerns\HasDatalist;
    use Concerns\HasPlaceholder;
    
    use Concerns\CanBeAutocompleted;
    use Concerns\CanBeDateConstrained;

    protected string $view = 'ui::builders.inputs.date';
}
