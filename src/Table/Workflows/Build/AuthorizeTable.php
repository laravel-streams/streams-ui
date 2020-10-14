<?php

namespace Streams\Ui\Table\Workflows\Build;

use Streams\Ui\Table\TableBuilder;
use Streams\Ui\Table\TableAuthorizer;

/**
 * Class AuthorizeTable
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AuthorizeTable
{

    /**
     * Handle the command.
     *
     * @param TableAuthorizer $authorizer
     * @param TableBuilder $builder
     */
    public function handle(TableAuthorizer $authorizer, TableBuilder $builder)
    {
        $authorizer->authorize($builder);
    }
}
