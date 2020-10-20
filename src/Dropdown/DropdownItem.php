<?php

namespace Streams\Ui\Dropdown;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Component;
use Streams\Ui\Support\Traits\HtmlTag;

/**
 * Class DropdownItem
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class DropdownItem extends Component
{

    use HtmlTag;

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        return parent::initializePrototype(array_merge([
            'template' => 'ui::dropdown/item',
            'component' => 'dropdown_item',

            'tag' => 'a',
            'url' => null,
            'text' => null,
            'entry' => null,
            'policy' => null,
            'enabled' => true,
            'primary' => false,
            'disabled' => false,
            'type' => 'default',
            'classes' => ['dropdown__item'],
        ], $attributes));
    }
}
