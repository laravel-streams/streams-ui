<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\RadioInput;
use Streams\Ui\Tests\UiTestCase;

class RadioInputTest extends UiTestCase
{
    protected function getTestInput(): RadioInput
    {
        return RadioInput::make('radio_field');
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $input = $this->getTestInput();

        $this->assertInstanceOf(Input::class, $input);
        $this->assertInstanceOf(RadioInput::class, $input);
    }

    /** @test */
    public function it_has_default_view()
    {
        $input = $this->getTestInput();

        $this->assertEquals('ui::components.inputs.radio', $input->getView());
    }

    /** @test */
    public function it_can_set_and_get_options()
    {
        $input = $this->getTestInput();
        $options = ['yes' => 'Yes', 'no' => 'No', 'maybe' => 'Maybe'];

        $result = $input->options($options);

        $this->assertSame($input, $result);
        $this->assertEquals($options, $input->getOptions());
    }

    /** @test */
    public function it_evaluates_closure_options()
    {
        $input = $this->getTestInput();

        $input->options(fn () => ['opt1' => 'Option 1', 'opt2' => 'Option 2']);

        $this->assertEquals(['opt1' => 'Option 1', 'opt2' => 'Option 2'], $input->getOptions());
    }

    /** @test */
    public function it_can_set_and_get_placeholder()
    {
        $input = $this->getTestInput();

        $result = $input->placeholder('Choose an option');

        $this->assertSame($input, $result);
        $this->assertEquals('Choose an option', $input->getPlaceholder());
    }
}
