<?php namespace Anomaly\Streams\Ui\ControlPanel\Event;

use Anomaly\Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ControlPanelWasBuilt
 * @package Anomaly\Streams\Ui\ControlPanel\Event
 */
class ControlPanelWasBuilt
{

    /**
     * @var ControlPanelBuilder
     */
    protected $builder;

    /**
     * ControlPanelWasBuilt constructor.
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
