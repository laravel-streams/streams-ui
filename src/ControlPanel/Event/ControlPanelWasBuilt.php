<?php namespace Streams\Ui\ControlPanel\Event;

use Streams\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class ControlPanelWasBuilt
 * @package Streams\Ui\ControlPanel\Event
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
