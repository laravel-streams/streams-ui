<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Builders\Inputs\ColorInput;
use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Tests\UiTestCase;

class ColorInputTest extends UiTestCase
{
    protected function getTestInput(): ColorInput
    {
        return ColorInput::make('color_field');
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $input = $this->getTestInput();

        $this->assertInstanceOf(Input::class, $input);
        $this->assertInstanceOf(ColorInput::class, $input);
    }

    /** @test */
    public function it_has_default_view()
    {
        $input = $this->getTestInput();

        $this->assertEquals('ui::builders.inputs.color', $input->getView());
    }

    /** @test */
    public function it_can_set_and_get_placeholder()
    {
        $input = $this->getTestInput();

        $result = $input->placeholder('Choose a color');

        $this->assertSame($input, $result);
        $this->assertEquals('Choose a color', $input->getPlaceholder());
    }

    /** @test */
    public function it_can_set_label()
    {
        $input = $this->getTestInput();

        $input->label('Primary Color');

        $this->assertEquals('Primary Color', $input->getLabel());
    }
}
