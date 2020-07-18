<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Ui\ControlPanel\Event\ControlPanelWasBuilt;
use Anomaly\Streams\Platform\Ui\ControlPanel\Event\ControlPanelIsBuilding;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\ButtonBuilder;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button\ButtonHandler;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionBuilder;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionHandler;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut\ShortcutBuilder;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut\ShortcutHandler;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationBuilder;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationHandler;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Command\SetActiveSection;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Command\SetMainNavigationLinks;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\Command\SetActiveNavigationLink;

/**
 * Class ControlPanelBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ControlPanelBuilder
{

    /**
     * The section buttons.
     *
     * @var array
     */
    protected $buttons = ButtonHandler::class;

    /**
     * The module sections.
     *
     * @var array
     */
    protected $sections = SectionHandler::class;

    /**
     * The shortcut components.
     *
     * @var array
     */
    protected $shortcuts = ShortcutHandler::class;

    /**
     * The navigation links.
     *
     * @var array
     */
    protected $navigation = NavigationHandler::class;

    /**
     * The control_panel object.
     *
     * @var ControlPanel
     */
    public $controlPanel;

    /**
     * Create a new ControlPanelBuilder instance.
     *
     * @param ControlPanel $controlPanel
     */
    public function __construct(ControlPanel $controlPanel)
    {
        $this->controlPanel = $controlPanel;
    }

    /**
     * Build the control_panel.
     */
    public function build()
    {
        $this->fire('ready', ['builder' => $this]);

        event(new ControlPanelIsBuilding($this));

        assets('scripts.js', 'streams::js/cp/click.js');

        NavigationBuilder::build($this);

        dispatch_now(new SetActiveNavigationLink($this));
        dispatch_now(new SetMainNavigationLinks($this));

        SectionBuilder::build($this);

        dispatch_now(new SetActiveSection($this));

        ShortcutBuilder::build($this);
        ButtonBuilder::build($this);

        event(new ControlPanelWasBuilt($this));

        $this->fire('built', ['builder' => $this]);

        return $this->controlPanel;
    }
}
