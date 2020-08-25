<?php

namespace Anomaly\Streams\Ui\Input;

use Anomaly\Streams\Ui\Support\Component;

/**
 * Class Input
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Input extends Component
{

    /**
     * The input attributes.
     *
     * @var array
     */
    protected $attributes = [
        'template' => 'ui::input/input',
        'component' => 'input',
        'type' => 'text',
        'field' => null,
    ];
}
