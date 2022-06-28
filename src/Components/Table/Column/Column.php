<?php

namespace Streams\Ui\Components\Table\Column;

use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;

class Column extends Component
{

    public string $component = 'column';
    
    // public string $value = null;
    // public string $heading = null;
    // public string $wrapper = null;

    public function href()
    {
        $direction = 'asc';

        $current = $this->direction;

        if ($current == 'asc') {
            $direction = 'desc';
        }

        if ($current == 'desc') {
            return URL::current();
        }

        $query = [
            'sort' => $direction,
            'order_by' => ($this->field ?: $this->handle),
        ];

        if ($view = Request::get($this->table->prefix('view'))) {
            $query[$this->table->prefix('view')] = $view;
        }

        return URL::current() . '?' . http_build_query($query);
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
