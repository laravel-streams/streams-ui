<?php

namespace Anomaly\Streams\Ui\Form\Component\Field\Workflows;

use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Ui\Form\Component\Field\Workflows\Fields\ApplyFields;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponents;
use Anomaly\Streams\Ui\Support\Workflows\ParseComponents;
use Anomaly\Streams\Ui\Support\Workflows\ResolveComponents;
use Anomaly\Streams\Ui\Support\Workflows\TranslateComponents;
use Anomaly\Streams\Ui\Form\Component\Field\Workflows\Fields\DefaultFields;
use Anomaly\Streams\Ui\Form\Component\Field\Workflows\Fields\PopulateFields;
use Anomaly\Streams\Ui\Form\Component\Field\Workflows\Fields\NormalizeFields;

/**
 * Class BuildFields
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildFields extends Workflow
{
    protected $steps = [
        'resolve_fields' => ResolveComponents::class,

        DefaultFields::class,
        NormalizeFields::class,
        
        'translate_fields' => TranslateComponents::class,
        'parse_fields' => ParseComponents::class,

        'build_fields' => BuildComponents::class,

        ApplyFields::class,

        'populate_fields' => PopulateFields::class,
    ];
}
