<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class Alert extends Component
{
    public function initializeComponentPrototype(array $attributes = [])
    {
        return parent::initializeComponentPrototype(array_merge([
            'component' => 'alert',
            'template'  => 'ui::components.alert',

            'text'     => null,
            'disabled' => false,
            'type'     => 'secondary',
            'classes'  => [
                'a-alert',
            ],
            'buttons' => [],
            'attributes' => [],
        ], $attributes));
    }

    public function class($extra = [])
    {
        $extra[] = '-' . $this->type;

        return parent::class($extra);
    }
}
