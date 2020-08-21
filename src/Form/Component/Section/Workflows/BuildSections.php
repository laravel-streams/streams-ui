<?php

namespace Anomaly\Streams\Ui\Form\Component\Section\Workflows;

use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Ui\Support\Workflows\BuildComponents;
use Anomaly\Streams\Ui\Support\Workflows\ParseComponents;
use Anomaly\Streams\Ui\Support\Workflows\ResolveComponents;
use Anomaly\Streams\Ui\Support\Workflows\TranslateComponents;
use Anomaly\Streams\Ui\Form\Component\Section\Workflows\Sections\DefaultSections;
use Anomaly\Streams\Ui\Form\Component\Section\Workflows\Sections\PopulateSections;
use Anomaly\Streams\Ui\Form\Component\Section\Workflows\Sections\NormalizeSections;

/**
 * Class BuildSections
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildSections extends Workflow
{
    protected $steps = [
        'resolve_sections' => ResolveComponents::class,

        //DefaultSections::class,
        //NormalizeSections::class,

        //'merge_sections' => MergeComponents::class,

        'translate_sections' => TranslateComponents::class,
        'parse_sections' => ParseComponents::class,

        'build_sections' => BuildComponents::class,
        
        //'populate_sections' => PopulateSections::class,
    ];
}
