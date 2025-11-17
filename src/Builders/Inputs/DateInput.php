<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Builders\Inputs\Traits;

class DateInput extends Input
{
    use Traits\HasStep;
    use Traits\HasDatalist;
    use Traits\HasPlaceholder;
    
    use Traits\CanBeAutocompleted;
    use Traits\CanBeDateConstrained;

    protected string $view = 'ui::builders.inputs.date';
}
