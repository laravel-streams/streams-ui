<?php

namespace Anomaly\Streams\Ui\Input;

use Anomaly\Streams\Ui\Support\Component;

/**
 * Class Textarea
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Textarea extends Component
{

    /**
     * The input attributes.
     *
     * @var array
     */
    protected $attributes = [
        'component' => 'input',
        //'tag' => 'input',
        'type' => 'text',
        'field' => null,
    ];
}
