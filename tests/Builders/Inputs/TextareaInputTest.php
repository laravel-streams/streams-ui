<?php

namespace Streams\Ui\Tests\Builders\Inputs;

use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\TextareaInput;

class TextareaInputTest extends UiTestCase
{
    protected function getTestInput(): TextareaInput
    {
        return TextareaInput::make('textarea_field');
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $input = $this->getTestInput();

        $this->assertInstanceOf(Input::class, $input);
        $this->assertInstanceOf(TextareaInput::class, $input);
    }

    /** @test */
    public function it_has_default_view()
    {
        $input = $this->getTestInput();

        $this->assertEquals('ui::components.inputs.textarea', $input->getView());
    }

    /** @test */
    public function it_can_set_and_get_placeholder()
    {
        $input = $this->getTestInput();

        $result = $input->placeholder('Enter text');

        $this->assertSame($input, $result);
        $this->assertEquals('Enter text', $input->getPlaceholder());
    }

    /** @test */
    public function it_can_set_and_get_rows()
    {
        $input = $this->getTestInput();

        $result = $input->rows(5);

        $this->assertSame($input, $result);
        $this->assertEquals(5, $input->getRows());
    }

    /** @test */
    public function it_evaluates_closure_rows()
    {
        $input = $this->getTestInput();

        $input->rows(fn () => 10);

        $this->assertEquals(10, $input->getRows());
    }

    /** @test */
    public function it_can_set_and_get_columns()
    {
        $input = $this->getTestInput();

        $result = $input->columns(80);

        $this->assertSame($input, $result);
        $this->assertEquals(80, $input->getColumns());
    }

    /** @test */
    public function it_evaluates_closure_columns()
    {
        $input = $this->getTestInput();

        $input->columns(fn () => 100);

        $this->assertEquals(100, $input->getColumns());
    }

    /** @test */
    public function it_can_set_min_length()
    {
        $input = $this->getTestInput();

        $result = $input->minLength(10);

        $this->assertSame($input, $result);
        $this->assertEquals(10, $input->getMinLength());
    }

    /** @test */
    public function it_can_set_max_length()
    {
        $input = $this->getTestInput();

        $result = $input->maxLength(500);

        $this->assertSame($input, $result);
        $this->assertEquals(500, $input->getMaxLength());
    }

    /** @test */
    public function it_can_set_autocomplete()
    {
        $input = $this->getTestInput();

        $result = $input->autocomplete('on');

        $this->assertSame($input, $result);
        $this->assertEquals('on', $input->getAutocomplete());
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
