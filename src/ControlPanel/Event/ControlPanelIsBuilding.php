<?php namespace Anomaly\Streams\Ui\ControlPanel\Event;

use Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ControlPanelIsBuilding
 * @package Anomaly\Streams\Ui\ControlPanel\Event
 */
class ControlPanelIsBuilding
{

    /**
     * @var ControlPanelBuilder
     */
    protected $builder;

    /**
     * ControlPanelIsBuilding constructor.
     * @param ControlPanelBuilder $builder
     */
    public function __construct(ControlPanelBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @return ControlPanelBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }
}
