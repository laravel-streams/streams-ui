<?php namespace Streams\Ui\Table\Component\View\Type;

use Streams\Ui\Table\Component\View\Query\RecentlyModifiedQuery;
use Streams\Ui\Table\Component\View\View;

/**
 * Class RecentlyModified
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class RecentlyModified extends View
{

    /**
     * The view query.
     *
     * @var string
     */
    protected $query = RecentlyModifiedQuery::class;
}
