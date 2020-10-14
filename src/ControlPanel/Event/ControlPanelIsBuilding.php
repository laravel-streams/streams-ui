<?php namespace Streams\Ui\ControlPanel\Event;

use Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ControlPanelIsBuilding
 * @package Streams\Ui\ControlPanel\Event
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
