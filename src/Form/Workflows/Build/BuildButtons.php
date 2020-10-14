<?php

namespace Streams\Ui\Form\Workflows\Build;

use Illuminate\Support\Facades\Request;
use Streams\Ui\Form\FormBuilder;
use Streams\Ui\Support\Workflows\BuildChildren;

/**
 * Class BuildButtons
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildButtons extends BuildChildren
{
    public function handle(FormBuilder $builder)
    {
        if (Request::is('post')) {
            return;
        }
        
        $this->build($builder, 'buttons');
    }
}
