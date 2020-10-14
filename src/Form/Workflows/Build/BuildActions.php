<?php

namespace Streams\Ui\Form\Workflows\Build;

use Streams\Ui\Form\FormBuilder;
use Streams\Ui\Support\Workflows\BuildChildren;

/**
 * Class BuildActions
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildActions extends BuildChildren
{
    public function handle(FormBuilder $builder)
    {
        $this->build($builder, 'actions');
    }
}
