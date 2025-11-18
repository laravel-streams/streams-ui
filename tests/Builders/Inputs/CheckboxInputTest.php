<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Builders\Inputs\CheckboxInput;
use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Tests\UiTestCase;

class CheckboxInputTest extends UiTestCase
{
    protected function getTestInput(): CheckboxInput
    {
        return CheckboxInput::make('checkbox_field');
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $input = $this->getTestInput();

        $this->assertInstanceOf(Input::class, $input);
        $this->assertInstanceOf(CheckboxInput::class, $input);
    }

    /** @test */
    public function it_has_default_view()
    {
        $input = $this->getTestInput();

        $this->assertEquals('ui::builders.inputs.checkbox', $input->getView());
    }

    /** @test */
    public function it_can_set_name()
    {
        $input = CheckboxInput::make('terms_accepted');

        $this->assertEquals('terms_accepted', $input->getName());
    }

    /** @test */
    public function it_can_set_label()
    {
        $input = $this->getTestInput();

        $input->label('Accept terms and conditions');

        $this->assertEquals('Accept terms and conditions', $input->getLabel());
    }
}
