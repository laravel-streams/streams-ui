<?php

namespace Streams\Ui\Components;

use Streams\Core\Field\Field;
use Streams\Ui\Support\Component;

class Avatar extends Component
{
    public array $classes = [
        'a-avatar',
    ];

    #[Field([
        'config' => [
            'wrapper' => 'collection',
        ],
    ])]
    public array $attributes = [
        'style' => 'margin: 1rem;',
    ];

    public function initializeComponentPrototype(array $attributes = [])
    {
        return parent::initializeComponentPrototype(array_merge([
            'component' => 'avatar',
            'template'  => 'ui::components.avatar',

            'img' => null,
            'type' => 'rounded',
            'disabled' => false,
        ], $attributes));
    }
}
