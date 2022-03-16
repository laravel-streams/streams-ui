<?php

namespace Streams\Ui\Layout;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Component;
use Streams\Ui\Support\Facades\UI;

class Fields extends Component
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializeComponentPrototype(array $attributes)
    {
        return parent::initializeComponentPrototype(array_merge([
            'component' => 'fields',
            'template'  => 'ui::layouts.fields',
            'content' => [],
        ], $attributes));
    }
}
