<?php

namespace Streams\Ui\Table\Filter;

use Illuminate\Support\Str;
use Collective\Html\FormFacade;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Table\Filter\Query\GenericFilterQuery;

/**
 *
 * @typescript
 * @property bool $active default ' => false,
 * @property bool $exact default ' => false
 * @property \Streams\Ui\Table\Filter\FilterQuery $query default ' => null,
 */
class Filter extends Component
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    public function initializeComponentPrototype(array $attributes = [])
    {
        return parent::initializeComponentPrototype(array_merge([
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
            'placeholder' => $this->placeholder ?: Str::title(Str::humanize($this->handle)),
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
