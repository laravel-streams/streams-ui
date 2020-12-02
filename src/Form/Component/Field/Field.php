<?php

namespace Streams\Ui\Form\Component\Field;

use Illuminate\Support\Str;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\App;

/**
 * Class Field
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Field extends Component
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
            'tag'      => 'button',
            'as'       => 'button',
            'url'      => null,
            'text'     => null,
            'entry'    => null,
            'policy'   => null,
            'enabled'  => true,
            'primary'  => false,
            'disabled' => false,
            'type'     => 'default',

            // Extended
            'prefix'   => null,
            'redirect' => null,

            'save'   => true,
            'active' => false,

            'handle'  => 'default',
            'classes'  => [],
        ], $attributes));
    }

    public function label()
    {
        return $this->label ?: ($this->label = Str::title(Str::humanize($this->handle)));
    }

    public function input()
    {
        $attributes = ['field' => $this];

        $attributes['name'] = $this->name;

        return App::make('streams.input_types.' . ($this->input ?: 'input'), compact('attributes'));
    }

    public function class(array $classes = [])
    {
        return parent::class(array_merge([
            //'col-span-12',
        ], $classes));
    }

    /**
     * Return merged attributes.
     *
     * @param array $attributes
     */
    public function attributes(array $attributes = [])
    {
        return array_merge(parent::attributes(), [
            'class' => $this->class(),
            'value' => $this->handle,
            'type'  => $this->type,
            'name'  => 'action',
        ], $attributes);
    }
}
