<?php

namespace Streams\Ui\Alert;

use Streams\Ui\Support\Component;

class Alert extends Component
{
    public function initializeComponentPrototype(array $attributes = [])
    {
        return parent::initializeComponentPrototype(array_merge([
            'component' => 'alert',
            'template'  => 'ui::alerts.alert',

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
