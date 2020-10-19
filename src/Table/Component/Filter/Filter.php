<?php

namespace Streams\Ui\Table\Component\Filter;

use Streams\Ui\Support\Component;
use Streams\Ui\Table\Component\Filter\Query\GenericFilterQuery;

/**
 * Class Filter
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Filter extends Component
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
            'component' => 'filter',
            'template' => 'ui::table.partials.filter',

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
    public function getInput()
    {
        return null;
    }

    /**
     * Get the filter value.
     *
     * @return null|string
     */
    public function getValue()
    {
        return app('request')->get($this->getInputName());
    }

    /**
     * Get the filter name.
     *
     * @return string
     */
    public function getInputName()
    {
        return $this->prefix . 'filter_' . $this->handle;
    }
}
