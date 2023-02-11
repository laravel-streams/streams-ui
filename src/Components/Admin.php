<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Support\Component;

class Admin extends Component
{
    public string $template = 'ui::components.admin';

    protected string $layout = 'ui::layouts.admin';
}
