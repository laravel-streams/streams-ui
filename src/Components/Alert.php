<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class Alert extends Component
{
    public string $component = 'alert';

    public string $template = 'ui::components.alert';

    public string $text = 'Something just happened.';
    public string $type = 'secondary';
    
    public $classes  = [
        'a-alert',
    ];

    public array $buttons = [];

    public function class($extra = [])
    {
        $extra[] = '-' . $this->type;

        return parent::class($extra);
    }
}
