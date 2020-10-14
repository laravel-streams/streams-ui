<?php

namespace Streams\Ui\Form\Workflows\Build;

use Streams\Ui\Form\FormBuilder;
use Streams\Ui\Form\FormAuthorizer;

/**
 * Class AuthorizeForm
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AuthorizeForm
{

    /**
     * Handle the command.
     *
     * @param FormAuthorizer $authorizer
     * @param FormBuilder $builder
     */
    public function handle(FormAuthorizer $authorizer, FormBuilder $builder)
    {
        $authorizer->authorize($builder);
    }
}
