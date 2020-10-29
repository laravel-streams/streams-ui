<?php

namespace Streams\Ui\Table\Component\Column;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Support\Component;

/**
 * Class Column
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Column extends Component
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
            'component' => 'column',
            
            'view' => null,
            'value' => null,
            'entry' => null,
            'heading' => null,
            'wrapper' => null,
            'classes' => ['table__column'],
        ], $attributes));
    }

    /**
     * Return the column sorted URL.
     */
    public function href()
    {
        $direction = null;

        $current = Request::get($this->table->prefix('sort'));

        if (!$current) {
            $direction = 'asc';
        }

        if ($current == 'asc') {
            $direction = 'desc';
        }

        if ($current == 'desc') {
            return URL::current();
        }

        return URL::current() . '?order_by=' . $this->field . '&sort=' . $direction;
    }
}
