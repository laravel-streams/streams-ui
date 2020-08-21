<?php

namespace Anomaly\Streams\Ui\Form\Workflows\Build;

use Anomaly\Streams\Ui\Form\FormBuilder;
use Anomaly\Streams\Ui\Support\Workflows\BuildChildren;

/**
 * Class BuildSections
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildSections extends BuildChildren
{
    public function handle(FormBuilder $builder)
    {
        $this->build($builder, 'sections');
    }
}
