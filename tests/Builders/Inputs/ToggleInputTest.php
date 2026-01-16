<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\ToggleInput;

class ToggleInputTest extends UiTestCase
{
    protected function getTestInput(): ToggleInput
    {
        return ToggleInput::make('toggle_field');
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $input = $this->getTestInput();

        $this->assertInstanceOf(Input::class, $input);
        $this->assertInstanceOf(ToggleInput::class, $input);
    }

    /** @test */
    public function it_has_default_view()
    {
        $input = $this->getTestInput();

        $this->assertEquals('ui::components.inputs.toggle', $input->getView());
    }

    /** @test */
    public function it_can_set_name()
    {
        $input = ToggleInput::make('is_active');

        $this->assertEquals('is_active', $input->getName());
    }

    /** @test */
    public function it_can_set_label()
    {
        $input = $this->getTestInput();

        $input->label('Active Status');

        $this->assertEquals('Active Status', $input->getLabel());
    }
}
