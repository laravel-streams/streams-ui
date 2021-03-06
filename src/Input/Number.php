<?php

namespace Streams\Ui\Input;

use Illuminate\Support\Arr;

/**
 * Class Number
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Number extends Input
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
            'template' => 'ui::input/number',
            'type' => 'number',
        ], $attributes));
    }

    public function htmlAttributes(array $attributes = [])
    {
        return parent::htmlAttributes(array_merge([
            'min' => Arr::get($this->field->stream->ruleParameters($this->field->handle, 'min'), 0),
            'max' => Arr::get($this->field->stream->ruleParameters($this->field->handle, 'max'), 0),
        ], $attributes));
    }
}
