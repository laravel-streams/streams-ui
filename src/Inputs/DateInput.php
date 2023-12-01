<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Inputs\Concerns;

class DateInput extends Input
{
    use Concerns\HasStep;
    use Concerns\HasDatalist;
    use Concerns\HasPlaceholder;
    
    use Concerns\CanBeAutocompleted;
    use Concerns\CanBeDateConstrained;

    protected string $view = 'ui::components.inputs.date';
}
