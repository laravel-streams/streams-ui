<?php

namespace Streams\Ui\Layout;

use Streams\Ui\Support\Component;
use Streams\Ui\Support\Traits\HasContent;

class Layout extends Component
{

    use HasContent;

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
            'component' => 'layout',
            'template'  => 'ui::layouts.layout',
            'content' => [],
        ], $attributes));
    }
}
