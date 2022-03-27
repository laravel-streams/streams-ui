<?php namespace Streams\Ui\Components\Table\View\Type;

use Streams\Ui\Components\Table\View\Query\TrashQuery;
use Streams\Ui\Components\Table\View\View;

/**
 * Class Trash
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Trash extends View
{

    /**
     * The view query.
     *
     * @var string
     */
    protected $query = TrashQuery::class;
}
