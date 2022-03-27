<?php

namespace Streams\Ui\Components\Table\Column;

use Illuminate\Support\Facades\Request;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;

/**
 * Class Column
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 * @typescript
 * @property \Streams\Core\Entry\Entry $entry
 * @property string $view
 * @property string $direction
 * @property string $prefix
 * @property mixed $value
 * @property mixed $heading
 * @property mixed $wrapper
 * @property bool $sortable
 * @property \Streams\Core\Field\Field $field
 */
class Column extends Component
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
            'component' => 'column',
            'view' => null,
            'value' => null,
            'entry' => null,
            'heading' => null,
            'wrapper' => null,
        ], $attributes));
    }

    /**
     * Return the column sorted URL.
     */
    public function href()
    {
        $direction = null;

        $current = $this->direction();

        if (!$current) {
            $direction = 'asc';
        }

        if ($current == 'asc') {
            $direction = 'desc';
        }

        if ($current == 'desc') {
            return URL::current();
        }

        return URL::current() . '?order_by=' . ($this->field ?: $this->handle) . '&sort=' . $direction;
    }

    public function current()
    {
        return $this->direction ?: Request::get($this->prefix . 'sort');
    }

    public function direction()
    {
        return $this->direction ?: Request::get($this->prefix . 'sort');
    }

    public function isSortable()
    {
        if (is_bool($this->sortable)) {

            return $this->sortable;
        }

        return $this->stream && $this->stream->fields->has($this->field ?: $this->handle);
    }

    public function heading()
    {
        if ($this->heading === false) {
            return null;
        }

        if (
            !$this->heading
            && $this->stream
            && $this->stream->fields->has($this->handle)
        ) {
            return $this->heading = $this->stream->fields->get($this->handle)->name();
        }

        return $this->heading;
    }
}
