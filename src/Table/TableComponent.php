<?php

namespace Anomaly\Streams\Ui\Table;

use Illuminate\View\Component;
use Anomaly\Streams\Ui\Table\Table;
use Illuminate\Support\Facades\View;

/**
 * Class TableComponent
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class TableComponent extends Component
{

    /**
     * The table instance.
     *
     * @var Table
     */
    public $table;

    /**
     * Create a new TableComponent class.
     *
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        $this->table = $table;
    }

    /**
     * Return the component view.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return View::make('ui::table/component');
    }
}
