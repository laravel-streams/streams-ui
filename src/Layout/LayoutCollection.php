<?php

namespace Streams\Ui\Layout;

use Illuminate\Support\Collection;

class LayoutCollection extends Collection
{

    /**
     * Render the buttons.
     * 
     * @return string
     */
    public function render()
    {
        return (string) $this->map(function($item) {
            return (string) $item->render();
        })->implode("\n");
    }
    /**
     * Render the actions.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
