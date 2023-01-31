<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Component;

class Fields extends Component
{
    public string $template = 'ui::components.fields';

    public array $fields = [];
}
