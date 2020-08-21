<?php

namespace Anomaly\Streams\Ui\Form\Workflows\Build;

use Illuminate\Support\Arr;
use Anomaly\Streams\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponents;
use Anomaly\Streams\Ui\Support\Workflows\ParseComponents;
use Anomaly\Streams\Ui\Support\Workflows\ResolveComponents;
use Anomaly\Streams\Ui\Form\Component\Field\FieldCollection;
use Anomaly\Streams\Ui\Support\Workflows\TranslateComponents;
use Anomaly\Streams\Ui\Form\Component\Field\Workflows\FieldsWorkflow;
use Anomaly\Streams\Ui\Form\Component\Field\Workflows\Fields\DefaultFields;
use Anomaly\Streams\Ui\Form\Component\Field\Workflows\Fields\PopulateFields;
use Anomaly\Streams\Ui\Form\Component\Field\Workflows\Fields\NormalizeFields;
use Anomaly\Streams\Ui\Support\Workflows\BuildChildren;

/**
 * Class BuildFields
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildFields extends BuildChildren
{

    public function handle(FormBuilder $builder)
    {
        $this->build($builder, 'fields');
    }
}
