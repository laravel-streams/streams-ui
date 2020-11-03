<?php

namespace Streams\Ui\Form\Component\Section\Workflows;

use Streams\Core\Support\Workflow;
use Streams\Ui\Support\Workflows\BuildComponents;
use Streams\Ui\Support\Workflows\ParseComponents;
use Streams\Ui\Support\Workflows\ResolveComponents;
use Streams\Ui\Support\Workflows\TranslateComponents;
use Streams\Ui\Form\Component\Section\Workflows\Sections\DefaultSections;
use Streams\Ui\Form\Component\Section\Workflows\Sections\PopulateSections;
use Streams\Ui\Form\Component\Section\Workflows\Sections\NormalizeSections;

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
        //'resolve_sections' => ResolveComponents::class,

        //DefaultSections::class,
        //NormalizeSections::class,

        //'merge_sections' => MergeComponents::class,

        //'translate_sections' => TranslateComponents::class,
        //'parse_sections' => ParseComponents::class,

        'build_sections' => BuildComponents::class,
        
        //'populate_sections' => PopulateSections::class,
    ];
}
