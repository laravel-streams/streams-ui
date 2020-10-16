<?php

namespace Streams\Ui\Button;

use Collective\Html\HtmlFacade;
use Streams\Ui\Support\Component;

/**
 * Class Button
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Button extends Component
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        return parent::initializePrototype(array_merge([
            'tag' => 'a',
            'url' => null,
            'text' => null,
            'entry' => null,
            'policy' => null,
            'enabled' => true,
            'primary' => false,
            'disabled' => false,
            'type' => 'default',
            'class' => 'button',
        ], $attributes));
    }

    /**
     * Return the open tag.
     *
     * @param array $attributes
     * @return string
     */
    public function open(array $attributes = [])
    {
        return '<' . $this->tag . ' ' . HtmlFacade::attributes($this->attributes($attributes)) . '>';
    }

    /**
     * Return the close tag.
     *
     * @return string
     */
    public function close()
    {
        return '</' . $this->tag . '>';
    }

    /**
     * Return the button attributes array.
     *
     * @param array $attributes
     */
    public function attributes(array $attributes = [])
    {
        return array_filter(array_merge([
            'name' => $this->name,
            'class' => $this->class,
        ], $this->getPrototypeAttribute('attributes', []), $attributes));
    }
}
