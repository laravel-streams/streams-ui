<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
class Dropdown extends Component
{

    public function initializeComponentPrototype(array $attributes = [])
    {
        return parent::initializeComponentPrototype(array_merge([
            'component' => 'dropdown',
            'template'  => 'ui::components.dropdown',

            'tag'      => 'a',
            'url'      => null,
            'text'     => null,
            'entry'    => null,
            'policy'   => null,
            'enabled'  => true,
            'primary'  => false,
            'disabled' => false,
            'type'     => 'default',
            'classes'  => [
                'o-dropdown',
            ],
            'attributes' => [],
        ], $attributes));
    }
}
