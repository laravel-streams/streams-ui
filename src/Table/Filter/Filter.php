<?php

namespace Streams\Ui\Table\Filter;

use Illuminate\Support\Str;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\App;
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
    public function input()
    {
        $attributes = ['field' => $this];

        $attributes = array_diff_key($this->getPrototypeAttributes(), array_flip([
            'classes',
            'template',
            'component',
        ]));

        $attributes['value'] = $this->value();
        $attributes['name']  = $this->inputName();
        $attributes['placeholder']  = Str::title($this->name());

        return App::make('streams.ui.input_types.' . ($this->input ?: 'input'), [
            'attributes' => $attributes,
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
