<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class Avatar extends Component
{
    public function initializeComponentPrototype(array $attributes = [])
    {
        return parent::initializeComponentPrototype(array_merge([
            'component' => 'avatar',
            'template'  => 'ui::components.avatar',

            'img' => null,
            'type' => 'rounded',
            'disabled' => false,
            'classes'  => [
                'a-avatar',
            ],
            'buttons' => [],
            'attributes' => [],
        ], $attributes));
    }
}
