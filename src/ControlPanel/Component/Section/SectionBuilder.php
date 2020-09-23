<?php

namespace Anomaly\Streams\Ui\ControlPanel\Component\Section;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder;
use Anomaly\Streams\Ui\ControlPanel\Component\Section\SectionInput;
use Anomaly\Streams\Ui\ControlPanel\Component\Section\SectionFactory;
use Anomaly\Streams\Ui\ControlPanel\Component\Navigation\NavigationLink;
use Anomaly\Streams\Ui\ControlPanel\Component\Section\SectionCollection;

/**
 * Class SectionBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SectionBuilder
{

    /**
     * Build the sections and push them to the control_panel.
     *
     * @param ControlPanelBuilder $builder
     * @param NavigationLink $link
     */
    public static function build(ControlPanelBuilder $builder)
    {
        foreach ($builder->getControlPanelNavigation() as $link) {

            $controlPanel = $builder->getControlPanel();

            $factory = app(SectionFactory::class);

            SectionInput::read($builder, $link);

            $sections = array_values($builder->getSections());

            foreach ($sections as $i => &$section) {

                if (($policy = Arr::get($section, 'policy')) && !Gate::any((array) $policy)) {
                    continue;
                }

                $controlPanel->addSection(
                    $section = $factory->make($section)
                );

                /**
                 * Merge defaul attributes.
                 */
                $section->setPrototypeAttribute('data-keymap', $i + 1);
            }

            $link->sections = new SectionCollection($sections);
        }
    }
}
