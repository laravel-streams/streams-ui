<?php

namespace Streams\Ui\Button;

use Streams\Ui\Support\Component;
use Streams\Ui\Support\Traits\HtmlTag;

/**
 * Class Button
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Button extends Component
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
            'component' => 'button',
            'template' => 'ui::buttons.button',

            'tag' => 'a',
            'url' => null,
            'text' => null,
            'entry' => null,
            'policy' => null,
            'enabled' => true,
            'primary' => false,
            'disabled' => false,
            'type' => 'default',
            'classes' => ['button'],
        ], $attributes));
    }

    /**
     * Return the button attributes array.
     *
     * @param array $attributes
     */
    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_filter(array_merge([
            'name' => $this->name,
            'value' => $this->value,
            'class' => $this->class(),
        ], $attributes)));
    }
}
