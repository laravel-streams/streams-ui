<?php

namespace Streams\Ui\Components;

use Streams\Core\Field\Field;
use Streams\Ui\Support\Component;
use Streams\Ui\Components\ControlPanel\ControlPanelBuilder;
use Streams\Ui\Components\ControlPanel\Navigation\NavigationCollection;

class ControlPanel extends Component
{
    public string $component = 'cp';
    public string $template  = 'ui::components.cp.cp';
    public string $builder = ControlPanelBuilder::class;

    #[Field([
        'type' => 'array',
        'config' => [
            'wrapper' => 'collection',
        ],
    ])]
    public $buttons = [];

    #[Field([
        'type' => 'array',
        'config' => [
            'wrapper' => 'collection',
        ],
    ])]
    public $shortcuts = [];

    #[Field([
        'type' => 'array',
        'config' => [
            'wrapper' => NavigationCollection::class,
        ],
    ])]
    public $navigation = [];
}
