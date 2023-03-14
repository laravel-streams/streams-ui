<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class Alerts extends Component
{
    public string $template = 'ui::components.alerts';

    public array $alerts = [];
}
