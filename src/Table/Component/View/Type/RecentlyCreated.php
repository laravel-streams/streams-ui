<?php namespace Streams\Ui\Table\Component\View\Type;

use Streams\Ui\Table\Component\View\Query\RecentlyCreatedQuery;
use Streams\Ui\Table\Component\View\View;

/**
 * Class RecentlyCreated
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class RecentlyCreated extends View
{

    /**
     * The view query.
     *
     * @var string
     */
    protected $query = RecentlyCreatedQuery::class;
}
