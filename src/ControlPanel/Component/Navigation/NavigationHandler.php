<?php

namespace Anomaly\Streams\Ui\ControlPanel\Component\Navigation;

use Anomaly\Streams\Platform\Addon\Module\Module;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Ui\ControlPanel\Component\Navigation\Event\GatherNavigation;
use Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class NavigationHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NavigationHandler
{

    /**
     * Handle the navigation.
     *
     * @param ControlPanelBuilder $builder
     * @param ModuleCollection $modules
     */
    public function handle(ControlPanelBuilder $builder, ModuleCollection $modules)
    {
        $navigation = [];

        /* @var Module $module */
        foreach ($modules->enabled()->accessible()->instances() as $module) {
            if ($module->getNavigation()) {
                $navigation[$module->getHandle()] = $module;
            }
        }

        $builder->setNavigation(
            array_map(
                function (Module $module) {
                    return [
                        'breadcrumb' => $module->getName(),
                        'title'      => $module->getName(),
                        'icon'       => $module->getIcon(),
                        'handle'       => $module->getNamespace(),
                        'href'       => 'admin/' . $module->getHandle(),
                    ];
                },
                $navigation
            )
        );

        event(new GatherNavigation($builder));

        return $builder->getNavigation();
    }
}
