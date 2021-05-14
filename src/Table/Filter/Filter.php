<?php

namespace Streams\Ui\Table\Filter;

use Illuminate\Support\Str;
use Collective\Html\FormFacade;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Table\Filter\Query\GenericFilterQuery;

class Filter extends Component
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
            'component' => 'filter',
            'template' => 'ui::form.input',

            'handle' => null,
            'field' => null,
            'stream' => null,
            'prefix' => null,
            'column' => null,

            'placeholder' => null,

            'active' => false,
            'exact' => false,

            'query' => GenericFilterQuery::class,
        ], $attributes));
    }

    /**
     * @todo finish this
     * Get the filter input.
     *
     * @return null|string
     */
    public function render()
    {
        $attributes = ['field' => $this->field];

        $attributes = array_diff_key($this->getPrototypeAttributes(), array_flip([
            'classes',
            'template',
            'component',
        ]));

        return FormFacade::input('text', $this->inputName(), $this->value(), [
            'placeholder' => $this->placeholder ?: Str::title($this->handle),
        ]);
    }

    /**
     * Get the filter value.
     *
     * @return null|string
     */
    public function value()
    {
        return Request::get($this->inputName());
    }

    /**
     * Get the filter name.
     *
     * @return string
     */
    public function inputName()
    {
        return $this->prefix . /*'filter_' .*/ $this->handle;
    }
}
