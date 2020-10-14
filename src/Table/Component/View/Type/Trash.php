<?php namespace Streams\Ui\Table\Component\View\Type;

use Streams\Ui\Table\Component\View\Query\TrashQuery;
use Streams\Ui\Table\Component\View\View;

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
