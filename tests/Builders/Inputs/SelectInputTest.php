<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\SelectInput;

class SelectInputTest extends UiTestCase
{
    protected function getTestInput(): SelectInput
    {
        return SelectInput::make('select_field');
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $input = $this->getTestInput();

        $this->assertInstanceOf(Input::class, $input);
        $this->assertInstanceOf(SelectInput::class, $input);
    }

    /** @test */
    public function it_has_default_view()
    {
        $input = $this->getTestInput();

        $this->assertEquals('ui::components.inputs.select', $input->getView());
    }

    /** @test */
    public function it_can_set_and_get_options()
    {
        $input = $this->getTestInput();
        $options = ['option1' => 'Option 1', 'option2' => 'Option 2'];

        $result = $input->options($options);

        $this->assertSame($input, $result);
        $this->assertEquals($options, $input->getOptions());
    }

    /** @test */
    public function it_evaluates_closure_options()
    {
        $input = $this->getTestInput();

        $input->options(fn () => ['a' => 'A', 'b' => 'B']);

        $this->assertEquals(['a' => 'A', 'b' => 'B'], $input->getOptions());
    }

    /** @test */
    public function it_can_set_and_get_placeholder()
    {
        $input = $this->getTestInput();

        $result = $input->placeholder('Select an option');

        $this->assertSame($input, $result);
        $this->assertEquals('Select an option', $input->getPlaceholder());
    }

    /** @test */
    public function it_can_be_multiple()
    {
        $input = $this->getTestInput();

        $result = $input->multiple();

        $this->assertSame($input, $result);
        $this->assertTrue($input->isMultiple());
    }

    /** @test */
    public function it_can_disable_multiple()
    {
        $input = $this->getTestInput();

        $input->multiple(false);

        $this->assertFalse($input->isMultiple());
    }

    /** @test */
    public function it_evaluates_closure_multiple()
    {
        $input = $this->getTestInput();

        $input->multiple(fn () => true);

        $this->assertTrue($input->isMultiple());
    }

    /** @test */
    public function it_is_not_multiple_by_default()
    {
        $input = $this->getTestInput();

        $this->assertFalse($input->isMultiple());
    }

    /** @test */
    public function it_can_set_and_get_border_radius()
    {
        $input = $this->getTestInput();

        $result = $input->borderRadius('2xl');

        $this->assertSame($input, $result);
        $this->assertEquals('2xl', $input->getBorderRadius());
    }

    /** @test */
    public function it_evaluates_closure_border_radius()
    {
        $input = $this->getTestInput();

        $input->borderRadius(fn () => 'lg');

        $this->assertEquals('lg', $input->getBorderRadius());
    }
}
